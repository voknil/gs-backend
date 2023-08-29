<?php

namespace App\I18N;

use App\Exception\DictionaryNotFound;
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
     * @throws DictionaryNotFound
     */
    public function getTranslate(string $dictionaryId, string $locale): array
    {
        try {
            $dictionary = $this->translator->getCatalogue($locale)->all($dictionaryId);
            if (!$dictionary) {
                throw new DictionaryNotFound();
            }
            $translatedWord['id'] = $dictionaryId;
            $translatedWord['data']['locale'] = $locale;
            $translatedWord['data']['text'] = $dictionary;
            return $translatedWord;
        } catch (InvalidArgumentException $exception) {
            throw new DictionaryNotFound();
        }
    }

}
