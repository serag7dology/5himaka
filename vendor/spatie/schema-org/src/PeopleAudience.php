<?php

namespace Spatie\SchemaOrg;

use \Spatie\SchemaOrg\Contracts\AudienceContract;
use \Spatie\SchemaOrg\Contracts\IntangibleContract;
use \Spatie\SchemaOrg\Contracts\ThingContract;

/**
 * A set of characteristics belonging to people, e.g. who compose an item's
 * target audience.
 *
 * @see http://schema.org/PeopleAudience
 *
 */
class PeopleAudience extends BaseType implements AudienceContract, IntangibleContract, ThingContract
{
    /**
     * An additional type for the item, typically used for adding more specific
     * types from external vocabularies in microdata syntax. This is a
     * relationship between something and a class that the thing is in. In RDFa
     * syntax, it is better to use the native RDFa syntax - the 'typeof'
     * attribute - for multiple types. Schema.org tools may have only weaker
     * understanding of extra types, in particular those defined externally.
     *
     * @param string|string[] $additionalType
     *
     * @return static
     *
     * @see http://schema.org/additionalType
     */
    public function additionalType($additionalType)
    {
        return $this->setProperty('additionalType', $additionalType);
    }

    /**
     * An alias for the item.
     *
     * @param string|string[] $alternateName
     *
     * @return static
     *
     * @see http://schema.org/alternateName
     */
    public function alternateName($alternateName)
    {
        return $this->setProperty('alternateName', $alternateName);
    }

    /**
     * The target group associated with a given audience (e.g. veterans, car
     * owners, musicians, etc.).
     *
     * @param string|string[] $audienceType
     *
     * @return static
     *
     * @see http://schema.org/audienceType
     */
    public function audienceType($audienceType)
    {
        return $this->setProperty('audienceType', $audienceType);
    }

    /**
     * A description of the item.
     *
     * @param string|string[] $description
     *
     * @return static
     *
     * @see http://schema.org/description
     */
    public function description($description)
    {
        return $this->setProperty('description', $description);
    }

    /**
     * A sub property of description. A short description of the item used to
     * disambiguate from other, similar items. Information from other properties
     * (in particular, name) may be necessary for the description to be useful
     * for disambiguation.
     *
     * @param string|string[] $disambiguatingDescription
     *
     * @return static
     *
     * @see http://schema.org/disambiguatingDescription
     */
    public function disambiguatingDescription($disambiguatingDescription)
    {
        return $this->setProperty('disambiguatingDescription', $disambiguatingDescription);
    }

    /**
     * The geographic area associated with the audience.
     *
     * @param AdministrativeArea|AdministrativeArea[] $geographicArea
     *
     * @return static
     *
     * @see http://schema.org/geographicArea
     */
    public function geographicArea($geographicArea)
    {
        return $this->setProperty('geographicArea', $geographicArea);
    }

    /**
     * The identifier property represents any kind of identifier for any kind of
     * [[Thing]], such as ISBNs, GTIN codes, UUIDs etc. Schema.org provides
     * dedicated properties for representing many of these, either as textual
     * strings or as URL (URI) links. See [background
     * notes](/docs/datamodel.html#identifierBg) for more details.
     *
     * @param PropertyValue|PropertyValue[]|string|string[] $identifier
     *
     * @return static
     *
     * @see http://schema.org/identifier
     */
    public function identifier($identifier)
    {
        return $this->setProperty('identifier', $identifier);
    }

    /**
     * An image of the item. This can be a [[URL]] or a fully described
     * [[ImageObject]].
     *
     * @param ImageObject|ImageObject[]|string|string[] $image
     *
     * @return static
     *
     * @see http://schema.org/image
     */
    public function image($image)
    {
        return $this->setProperty('image', $image);
    }

    /**
     * Indicates a page (or other CreativeWork) for which this thing is the main
     * entity being described. See [background
     * notes](/docs/datamodel.html#mainEntityBackground) for details.
     *
     * @param CreativeWork|CreativeWork[]|string|string[] $mainEntityOfPage
     *
     * @return static
     *
     * @see http://schema.org/mainEntityOfPage
     */
    public function mainEntityOfPage($mainEntityOfPage)
    {
        return $this->setProperty('mainEntityOfPage', $mainEntityOfPage);
    }

    /**
     * The name of the item.
     *
     * @param string|string[] $name
     *
     * @return static
     *
     * @see http://schema.org/name
     */
    public function name($name)
    {
        return $this->setProperty('name', $name);
    }

    /**
     * Indicates a potential Action, which describes an idealized action in
     * which this thing would play an 'object' role.
     *
     * @param Action|Action[] $potentialAction
     *
     * @return static
     *
     * @see http://schema.org/potentialAction
     */
    public function potentialAction($potentialAction)
    {
        return $this->setProperty('potentialAction', $potentialAction);
    }

    /**
     * Audiences defined by a person's gender.
     *
     * @param string|string[] $requiredGender
     *
     * @return static
     *
     * @see http://schema.org/requiredGender
     */
    public function requiredGender($requiredGender)
    {
        return $this->setProperty('requiredGender', $requiredGender);
    }

    /**
     * Audiences defined by a person's maximum age.
     *
     * @param int|int[] $requiredMaxAge
     *
     * @return static
     *
     * @see http://schema.org/requiredMaxAge
     */
    public function requiredMaxAge($requiredMaxAge)
    {
        return $this->setProperty('requiredMaxAge', $requiredMaxAge);
    }

    /**
     * Audiences defined by a person's minimum age.
     *
     * @param int|int[] $requiredMinAge
     *
     * @return static
     *
     * @see http://schema.org/requiredMinAge
     */
    public function requiredMinAge($requiredMinAge)
    {
        return $this->setProperty('requiredMinAge', $requiredMinAge);
    }

    /**
     * URL of a reference Web page that unambiguously indicates the item's
     * identity. E.g. the URL of the item's Wikipedia page, Wikidata entry, or
     * official website.
     *
     * @param string|string[] $sameAs
     *
     * @return static
     *
     * @see http://schema.org/sameAs
     */
    public function sameAs($sameAs)
    {
        return $this->setProperty('sameAs', $sameAs);
    }

    /**
     * A CreativeWork or Event about this Thing.
     *
     * @param CreativeWork|CreativeWork[]|Event|Event[] $subjectOf
     *
     * @return static
     *
     * @see http://schema.org/subjectOf
     */
    public function subjectOf($subjectOf)
    {
        return $this->setProperty('subjectOf', $subjectOf);
    }

    /**
     * The gender of the person or audience.
     *
     * @param string|string[] $suggestedGender
     *
     * @return static
     *
     * @see http://schema.org/suggestedGender
     */
    public function suggestedGender($suggestedGender)
    {
        return $this->setProperty('suggestedGender', $suggestedGender);
    }

    /**
     * Maximal age recommended for viewing content.
     *
     * @param float|float[]|int|int[] $suggestedMaxAge
     *
     * @return static
     *
     * @see http://schema.org/suggestedMaxAge
     */
    public function suggestedMaxAge($suggestedMaxAge)
    {
        return $this->setProperty('suggestedMaxAge', $suggestedMaxAge);
    }

    /**
     * Minimal age recommended for viewing content.
     *
     * @param float|float[]|int|int[] $suggestedMinAge
     *
     * @return static
     *
     * @see http://schema.org/suggestedMinAge
     */
    public function suggestedMinAge($suggestedMinAge)
    {
        return $this->setProperty('suggestedMinAge', $suggestedMinAge);
    }

    /**
     * URL of the item.
     *
     * @param string|string[] $url
     *
     * @return static
     *
     * @see http://schema.org/url
     */
    public function url($url)
    {
        return $this->setProperty('url', $url);
    }

}
