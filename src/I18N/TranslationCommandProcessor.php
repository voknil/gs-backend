<?php

namespace App\I18N;

use App\Exception\UserLocaleNotSet;
use InvalidArgumentException;
use Symfony\Contracts\Translation\TranslatorInterface;

final class TranslationCommandProcessor
{
    public function __construct(
        private readonly TranslatorInterface $translator,
    )
    {
    }

    /**
     * @throws UserLocaleNotSet
     */
    public function getTranslate(string $dictionaryId, string $locale): array
    {
        try {
            $translatedWord['id'] = $dictionaryId;
            $translatedWord['data']['locale'] = $locale;
            $translatedWord['data']['text'] = $this->translator->getCatalogue($locale)->all($dictionaryId);
            return $translatedWord;
        } catch (InvalidArgumentException $exception) {
            throw new UserLocaleNotSet();
        }
    }

}
