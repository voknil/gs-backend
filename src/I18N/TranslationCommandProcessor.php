<?php

namespace App\I18N;

use App\Exception\DictionaryNotFound;
use App\Exception\UserLocaleNotSet;
use App\Response\Dictionary\LocaleData;
use App\Response\Dictionary\LocaleResponse;
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
    public function getTranslate(string $dictionaryId, string $locale): LocaleResponse
    {
        try {
            $dictionary = $this->translator->getCatalogue($locale)->all($dictionaryId);
            if (empty($dictionary)) {
                throw new DictionaryNotFound();
            }
            return new LocaleResponse($dictionaryId, $locale, $dictionary);
        } catch (InvalidArgumentException $exception) {
            throw new DictionaryNotFound();
        }
    }

}
