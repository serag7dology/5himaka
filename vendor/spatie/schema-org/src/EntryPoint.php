<?php

namespace Spatie\SchemaOrg;

use \Spatie\SchemaOrg\Contracts\IntangibleContract;
use \Spatie\SchemaOrg\Contracts\ThingContract;

/**
 * An entry point, within some Web-based protocol.
 *
 * @see http://schema.org/EntryPoint
 *
 */
class EntryPoint extends BaseType implements IntangibleContract, ThingContract
{
    /**
     * An application that can complete the request.
     *
     * @param SoftwareApplication|SoftwareApplication[] $actionApplication
     *
     * @return static
     *
     * @see http://schema.org/actionApplication
     */
    public function actionApplication($actionApplication)
    {
        return $this->setProperty('actionApplication', $actionApplication);
    }

    /**
     * The high level platform(s) where the Action can be performed for the
     * given URL. To specify a specific application or operating system
     * instance, use actionApplication.
     *
     * @param string|string[] $actionPlatform
     *
     * @return static
     *
     * @see http://schema.org/actionPlatform
     */
    public function actionPlatform($actionPlatform)
    {
        return $this->setProperty('actionPlatform', $actionPlatform);
    }

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
     * An application that can complete the request.
     *
     * @param SoftwareApplication|SoftwareApplication[] $application
     *
     * @return static
     *
     * @see http://schema.org/application
     */
    public function application($application)
    {
        return $this->setProperty('application', $application);
    }

    /**
     * The supported content type(s) for an EntryPoint response.
     *
     * @param string|string[] $contentType
     *
     * @return static
     *
     * @see http://schema.org/contentType
     */
    public function contentType($contentType)
    {
        return $this->setProperty('contentType', $contentType);
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
     * The supported encoding type(s) for an EntryPoint request.
     *
     * @param string|string[] $encodingType
     *
     * @return static
     *
     * @see http://schema.org/encodingType
     */
    public function encodingType($encodingType)
    {
        return $this->setProperty('encodingType', $encodingType);
    }

    /**
     * An HTTP method that specifies the appropriate HTTP method for a request
     * to an HTTP EntryPoint. Values are capitalized strings as used in HTTP.
     *
     * @param string|string[] $httpMethod
     *
     * @return static
     *
     * @see http://schema.org/httpMethod
     */
    public function httpMethod($httpMethod)
    {
        return $this->setProperty('httpMethod', $httpMethod);
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

    /**
     * An url template (RFC6570) that will be used to construct the target of
     * the execution of the action.
     *
     * @param string|string[] $urlTemplate
     *
     * @return static
     *
     * @see http://schema.org/urlTemplate
     */
    public function urlTemplate($urlTemplate)
    {
        return $this->setProperty('urlTemplate', $urlTemplate);
    }

}
