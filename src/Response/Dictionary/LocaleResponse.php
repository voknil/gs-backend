<?php

namespace App\Response\Dictionary;

class LocaleResponse
{
    private string $id;
    private LocaleData $data;

    /**
     * @param string $id
     * @param string $locale
     * @param array $dictionary
     */
    public function __construct(string $id, string $locale, array $dictionary)
    {
        $this->id = $id;
        $this->data = new LocaleData($locale, $dictionary);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return LocaleData
     */
    public function getData(): LocaleData
    {
        return $this->data;
    }


}
