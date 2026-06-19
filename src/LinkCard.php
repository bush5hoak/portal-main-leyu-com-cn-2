<?php

class LinkCard
{
    private string $url;
    private string $title;
    private string $description;
    private array $metadata;

    public function __construct(
        string $url = 'https://portal-main-leyu.com.cn',
        string $title = '乐鱼体育',
        string $description = '乐鱼体育 - 专业体育赛事平台',
        array $metadata = []
    ) {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->metadata = $metadata;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setMetadata(array $metadata): void
    {
        $this->metadata = $metadata;
    }

    public function addMetadata(string $key, string $value): void
    {
        $this->metadata[$key] = $value;
    }

    private function escapeHtml(string $input): string
    {
        return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    private function buildMetadataHtml(): string
    {
        if (empty($this->metadata)) {
            return '';
        }

        $html = '<div class="card-metadata">';
        foreach ($this->metadata as $key => $value) {
            $escapedKey = $this->escapeHtml($key);
            $escapedValue = $this->escapeHtml($value);
            $html .= sprintf(
                '<span class="metadata-item"><strong>%s:</strong> %s</span>',
                $escapedKey,
                $escapedValue
            );
        }
        $html .= '</div>';

        return $html;
    }

    public function render(): string
    {
        $escapedUrl = $this->escapeHtml($this->url);
        $escapedTitle = $this->escapeHtml($this->title);
        $escapedDescription = $this->escapeHtml($this->description);
        $metadataHtml = $this->buildMetadataHtml();

        $html = '<div class="link-card">';
        $html .= sprintf(
            '<a href="%s" class="card-link" target="_blank" rel="noopener noreferrer">',
            $escapedUrl
        );
        $html .= '<div class="card-content">';
        $html .= sprintf('<h3 class="card-title">%s</h3>', $escapedTitle);
        $html .= sprintf('<p class="card-description">%s</p>', $escapedDescription);
        $html .= $metadataHtml;
        $html .= '<div class="card-footer">';
        $html .= sprintf('<span class="card-url">%s</span>', $escapedUrl);
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</a>';
        $html .= '</div>';

        return $html;
    }

    public static function createDefault(): self
    {
        return new self(
            'https://portal-main-leyu.com.cn',
            '乐鱼体育',
            '乐鱼体育 - 为您提供专业体育赛事信息',
            ['类型' => '体育', '平台' => '乐鱼']
        );
    }

    public static function createWithCustomData(
        string $url,
        string $title,
        string $description,
        array $metadata = []
    ): self {
        return new self($url, $title, $description, $metadata);
    }
}

function renderLinkCard(
    string $url = 'https://portal-main-leyu.com.cn',
    string $title = '乐鱼体育',
    string $description = '乐鱼体育 - 专业体育赛事平台',
    array $metadata = []
): string {
    $card = new LinkCard($url, $title, $description, $metadata);
    return $card->render();
}

$defaultCard = LinkCard::createDefault();
echo $defaultCard->render();

$customCard = LinkCard::createWithCustomData(
    'https://portal-main-leyu.com.cn',
    '乐鱼体育',
    '乐鱼体育 - 专业体育赛事平台',
    ['类别' => '体育', '来源' => '乐鱼']
);
echo $customCard->render();

$simpleCard = renderLinkCard();
echo $simpleCard;