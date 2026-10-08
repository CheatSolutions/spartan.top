<?php

function sp_docs_slug(string $file): string
{
    $name = preg_replace('/\.md$/i', '', trim($file));
    $slug = strtolower(trim((string)preg_replace('/[^a-z0-9]+/i', '-', $name), '-'));
    return $slug !== '' ? $slug : 'page';
}

function sp_docs_url(string $slug = ''): string
{
    global $website_url;
    $base = rtrim($website_url, '/') . '/documentation/';
    return $slug === '' ? $base : $base . '?page=' . rawurlencode($slug);
}

function sp_docs_cache_dir(): string
{
    $dir = rtrim(sys_get_temp_dir(), '/') . '/spartan-docs';

    if (!is_dir($dir)) {
        @mkdir($dir, 0775, true);
    }
    return $dir;
}

function sp_docs_http(string $url): ?string
{
    if (function_exists('curl_init')) {
        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 3,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_TIMEOUT => 6,
            CURLOPT_USERAGENT => 'spartan.top-docs'
        ]);
        $body = curl_exec($curl);
        $status = (int)curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        curl_close($curl);
        return ($body !== false && $status === 200) ? (string)$body : null;
    }
    $context = stream_context_create(['http' => ['timeout' => 6, 'header' => "User-Agent: spartan.top-docs\r\n"]]);
    $body = @file_get_contents($url, false, $context);
    return $body === false ? null : $body;
}

function sp_docs_cached(string $key, string $url, int $ttl): ?string
{
    $file = sp_docs_cache_dir() . '/' . preg_replace('/[^a-z0-9._-]/i', '_', $key);
    $exists = is_file($file);

    if ($exists && (time() - (int)filemtime($file)) < $ttl) {
        $content = @file_get_contents($file);

        if ($content !== false) {
            return $content;
        }
    }
    $body = sp_docs_http($url);

    if ($body !== null && trim($body) !== '') {
        $temporary = $file . '.' . bin2hex(random_bytes(4)) . '.tmp';

        if (@file_put_contents($temporary, $body) !== false) {
            @rename($temporary, $file);
        }
        return $body;
    }

    if ($exists) {
        @touch($file);
        $content = @file_get_contents($file);
        return $content === false ? null : $content;
    }
    return null;
}

function sp_docs_list(): array
{
    global $docs_api_url, $docs_meta, $docs_groups, $docs_fallback_files;
    $files = [];
    $json = sp_docs_cached('list.json', $docs_api_url, 3600);

    if ($json !== null) {
        $data = json_decode($json, true);

        if (is_array($data)) {
            foreach ($data as $item) {
                if (is_array($item) && ($item['type'] ?? '') === 'file' && preg_match('/\.md$/i', (string)($item['name'] ?? ''))) {
                    $files[] = (string)$item['name'];
                }
            }
        }
    }

    if (empty($files)) {
        $files = $docs_fallback_files;
    }
    $docs = [];

    foreach ($files as $file) {
        $slug = sp_docs_slug($file);
        $meta = $docs_meta[$slug] ?? [];
        $title = trim((string)preg_replace('/\.md$/i', '', trim($file)));
        $group = $meta['group'] ?? 'More';
        $docs[$slug] = [
            'slug' => $slug,
            'file' => $file,
            'title' => $meta['title'] ?? ucfirst($title),
            'description' => $meta['description'] ?? '',
            'group' => $group,
            'order' => $meta['order'] ?? 100,
            'rank' => (int)array_search($group, $docs_groups, true)
        ];
    }
    uasort($docs, function ($a, $b) {
        return [$a['rank'], $a['order'], $a['title']] <=> [$b['rank'], $b['order'], $b['title']];
    });
    return $docs;
}

function sp_docs_content(array $doc): ?string
{
    global $docs_raw_base;
    return sp_docs_cached('md-' . $doc['slug'] . '.md', $docs_raw_base . rawurlencode($doc['file']), 3600);
}

function sp_docs_rewrite_url(string $url, array $docs): string
{
    $pattern = '~^https://github\.com/CheatSolutions/Important-Information/(?:blob|tree)/main/documentation(?:/([^?#]*))?~i';

    if (preg_match($pattern, $url, $match)) {
        if (empty($match[1])) {
            return sp_docs_url();
        }
        $slug = sp_docs_slug(rawurldecode($match[1]));

        if (isset($docs[$slug])) {
            return sp_docs_url($slug);
        }
    }
    return $url;
}

function sp_md_escape(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function sp_md_inline(string $text, array $docs): string
{
    $tokens = [];
    $stash = function (string $html) use (&$tokens): string {
        $tokens[] = $html;
        return "\u{E000}" . (count($tokens) - 1) . "\u{E001}";
    };

    $text = preg_replace_callback('/(`{1,2})(.+?)\1/u', function ($match) use ($stash) {
        return $stash('<code>' . sp_md_escape($match[2]) . '</code>');
    }, $text);

    $text = preg_replace_callback('/<br\s*\/?>/i', function () use ($stash) {
        return $stash('<br>');
    }, $text);
    $text = preg_replace_callback('/<\/?p>/i', function () use ($stash) {
        return $stash('<br><br>');
    }, $text);
    $text = preg_replace_callback('/<(\/?)(b|strong)>/i', function ($match) use ($stash) {
        return $stash('<' . $match[1] . 'strong>');
    }, $text);

    $text = sp_md_escape($text);

    $text = preg_replace_callback('/!\[([^\]]*)\]\((https:\/\/[^)\s]+)\)/u', function ($match) use ($stash) {
        return $stash('<img src="' . $match[2] . '" alt="' . $match[1] . '" loading="lazy">');
    }, $text);

    $text = preg_replace_callback('/\[([^\]]+)\]\((https?:\/\/[^)\s]+)\)/u', function ($match) use ($stash, $docs) {
        $url = sp_docs_rewrite_url(html_entity_decode($match[2], ENT_QUOTES, 'UTF-8'), $docs);
        return $stash('<a href="' . sp_md_escape($url) . '" rel="noopener">' . $match[1] . '</a>');
    }, $text);

    $text = preg_replace('/\*\*(.+?)\*\*/u', '<strong>$1</strong>', $text);

    $text = preg_replace_callback('~(?<![\w/"=])https?://[^\s<\x{E000}]+~u', function ($match) use ($stash, $docs) {
        $url = $match[0];
        $trailing = '';

        if (preg_match('/[.,;:!?)]+$/', $url, $end)) {
            $trailing = $end[0];
            $url = substr($url, 0, -strlen($trailing));
        }
        $target = sp_docs_rewrite_url(html_entity_decode($url, ENT_QUOTES, 'UTF-8'), $docs);
        return $stash('<a href="' . sp_md_escape($target) . '" rel="noopener">' . $url . '</a>') . $trailing;
    }, $text);

    for ($i = 0; $i < 4; $i++) {
        $text = preg_replace_callback('/\x{E000}(\d+)\x{E001}/u', function ($match) use ($tokens) {
            return $tokens[(int)$match[1]] ?? '';
        }, $text);
    }
    return $text;
}

function sp_markdown(string $markdown, array $docs, array &$headings = []): string
{
    $lines = preg_split('/\R/u', str_replace("\xEF\xBB\xBF", '', $markdown));
    $html = '';
    $paragraph = [];
    $list = null;
    $listItems = [];
    $inCode = false;
    $code = [];
    $detailsBodies = [];
    $usedIds = [];

    $flush = function () use (&$html, &$paragraph, &$list, &$listItems, $docs) {
        if (!empty($paragraph)) {
            $html .= '<p>' . sp_md_inline(implode("\n", $paragraph), $docs) . '</p>';
            $paragraph = [];
        }

        if ($list !== null) {
            $html .= '<' . $list . '>';

            foreach ($listItems as $item) {
                $html .= '<li>' . sp_md_inline($item, $docs) . '</li>';
            }
            $html .= '</' . $list . '>';
            $list = null;
            $listItems = [];
        }
    };
    $closeCode = function () use (&$html, &$code, &$inCode) {
        $html .= '<pre><code>' . sp_md_escape(implode("\n", $code)) . '</code></pre>';
        $code = [];
        $inCode = false;
    };

    foreach ($lines as $line) {
        if ($inCode) {
            if (preg_match('/^(.*?)```\s*$/', $line, $match)) {
                if ($match[1] !== '') {
                    $code[] = $match[1];
                }
                $closeCode();
            } else {
                $code[] = $line;
            }
            continue;
        }

        if (preg_match('/^\s*```(.*)$/', $line, $match)) {
            $flush();
            $inCode = true;
            $rest = trim($match[1]);

            if ($rest !== '' && !preg_match('/^[a-z0-9+#-]{1,12}$/i', $rest)) {
                $code[] = $rest;
            }
            continue;
        }

        if (preg_match('/^\s*<details>\s*$/i', $line)) {
            $flush();
            $html .= '<details class="md-details" data-accordion>';
            $detailsBodies[] = false;
            continue;
        }

        if (preg_match('/^\s*<summary>(.*)<\/summary>\s*$/i', $line, $match)) {
            $flush();
            $html .= '<summary>' . sp_md_inline($match[1], $docs) . '</summary><div class="md-details-body">';

            if (!empty($detailsBodies)) {
                $detailsBodies[count($detailsBodies) - 1] = true;
            }
            continue;
        }

        if (preg_match('/^\s*<\/details>\s*$/i', $line)) {
            $flush();
            $hasBody = array_pop($detailsBodies);
            $html .= ($hasBody ? '</div>' : '') . '</details>';
            continue;
        }

        if (trim($line) === '') {
            $flush();
            continue;
        }

        if (preg_match('/^(#{1,6})\s+(.+?)\s*#*\s*$/u', $line, $match)) {
            $flush();
            $text = trim($match[2]);

            if (strlen($match[1]) === 1 && preg_match('~^https?://\S+$~', $text)) {
                continue;
            }
            $level = min(6, strlen($match[1]) + 1);
            $id = trim(strtolower((string)preg_replace('/[^a-z0-9]+/i', '-', strip_tags($text))), '-');
            $id = $id !== '' ? $id : 'section';

            for ($suffix = 2; isset($usedIds[$id]); $suffix++) {
                $id = preg_replace('/-\d+$/', '', $id) . '-' . $suffix;
            }
            $usedIds[$id] = true;

            if ($level <= 3) {
                $headings[] = ['id' => $id, 'text' => $text, 'level' => $level];
            }
            $html .= '<h' . $level . ' id="' . sp_md_escape($id) . '">' . sp_md_inline($text, $docs) . '</h' . $level . '>';
            continue;
        }

        if (preg_match('/^\s*\d+[.)]\s+(.*)$/', $line, $match)) {
            if ($list !== 'ol') {
                $flush();
                $list = 'ol';
            }
            $listItems[] = $match[1];
            continue;
        }

        if (preg_match('/^\s*[-*+]\s+(.*)$/', $line, $match)) {
            if ($list !== 'ul') {
                $flush();
                $list = 'ul';
            }
            $listItems[] = $match[1];
            continue;
        }

        if ($list !== null) {
            $flush();
        }
        $paragraph[] = trim($line);
    }

    if ($inCode) {
        $closeCode();
    }
    $flush();

    while (!empty($detailsBodies)) {
        $html .= (array_pop($detailsBodies) ? '</div>' : '') . '</details>';
    }
    return $html;
}
