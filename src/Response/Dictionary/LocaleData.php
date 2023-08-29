<?php

namespace App\Response\Dictionary;

class LocaleData
{
    private string $locale;
    private array $text;

    /**
     * @param string $locale
     * @param array $text
     */
    public function __construct(string $locale, array $text)
    {
        $this->locale = $locale;
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    /**
     * @return array
     */
    public function getText(): array
    {
        return $this->text;
    }

    /**
     * @param array $text
     */
    public function setText(array $text): void
    {
        $this->text = $text;
    }


}
