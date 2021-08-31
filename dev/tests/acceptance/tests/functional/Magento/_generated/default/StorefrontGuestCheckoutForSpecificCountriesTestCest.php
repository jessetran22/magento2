<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-13414: Storefront guest checkout for specific countries test")
 * @Description("Checkout flow if shipping rates are not available<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontGuestCheckoutForSpecificCountriesTest.xml<br>")
 * @TestCaseId("MC-13414")
 * @group checkout
 */
class StorefrontGuestCheckoutForSpecificCountriesTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create simple product");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
		$I->comment("Enable free shipping to specific country -  Afghanistan");
		$enableFreeShipping = $I->magentoCLI("config:set carriers/freeshipping/active 1", 60); // stepKey: enableFreeShipping
		$I->comment($enableFreeShipping);
		$allowFreeShippingSpecificCountries = $I->magentoCLI("config:set carriers/freeshipping/sallowspecific 1", 60); // stepKey: allowFreeShippingSpecificCountries
		$I->comment($allowFreeShippingSpecificCountries);
		$enableFreeShippingToAfghanistan = $I->magentoCLI("config:set carriers/freeshipping/specificcountry AF", 60); // stepKey: enableFreeShippingToAfghanistan
		$I->comment($enableFreeShippingToAfghanistan);
		$I->comment("Enable flat rate shipping to specific country -  Afghanistan");
		$enableFlatRate = $I->magentoCLI("config:set carriers/flatrate/active 1", 60); // stepKey: enableFlatRate
		$I->comment($enableFlatRate);
		$allowFlatRateSpecificCountries = $I->magentoCLI("config:set carriers/flatrate/sallowspecific 1", 60); // stepKey: allowFlatRateSpecificCountries
		$I->comment($allowFlatRateSpecificCountries);
		$enableFlatRateToAfghanistan = $I->magentoCLI("config:set carriers/flatrate/specificcountry AF", 60); // stepKey: enableFlatRateToAfghanistan
		$I->comment($enableFlatRateToAfghanistan);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Rollback all configurations");
		$disableFreeShipping = $I->magentoCLI("config:set carriers/freeshipping/active 0", 60); // stepKey: disableFreeShipping
		$I->comment($disableFreeShipping);
		$allowFreeShippingToAllCountries = $I->magentoCLI("config:set carriers/freeshipping/sallowspecific 0", 60); // stepKey: allowFreeShippingToAllCountries
		$I->comment($allowFreeShippingToAllCountries);
		$allowFlatRateToAllCountries = $I->magentoCLI("config:set carriers/flatrate/sallowspecific 0", 60); // stepKey: allowFlatRateToAllCountries
		$I->comment($allowFlatRateToAllCountries);
		$I->comment("Delete product");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"Checkout"})
	 * @Stories({"Checkout for Specific Countries"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontGuestCheckoutForSpecificCountriesTest(AcceptanceTester $I)
	{
		$I->comment("Add product to cart");
		$I->comment("Entering Action Group [openProductPage] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] OpenStoreFrontProductPageActionGroup");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageAddProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Go to checkout page");
		$I->comment("Entering Action Group [openCheckoutShippingPage] OpenStoreFrontCheckoutShippingPageActionGroup");
		$I->amOnPage("/checkout/#shipping"); // stepKey: amOnCheckoutShippingPageOpenCheckoutShippingPage
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutShippingPageLoadOpenCheckoutShippingPage
		$I->comment("Exiting Action Group [openCheckoutShippingPage] OpenStoreFrontCheckoutShippingPageActionGroup");
		$I->comment("Assert shipping methods are unavailable");
		$I->comment("Entering Action Group [dontSeeFlatRateShippingMethod] AssertStoreFrontShippingMethodUnavailableActionGroup");
		$I->waitForElementNotVisible("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..", 30); // stepKey: waitForShippingMethodNotVisibleDontSeeFlatRateShippingMethod
		$I->dontSeeElement("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/.."); // stepKey: dontSeeShippingMethodDontSeeFlatRateShippingMethod
		$I->comment("Exiting Action Group [dontSeeFlatRateShippingMethod] AssertStoreFrontShippingMethodUnavailableActionGroup");
		$I->comment("Entering Action Group [dontFreeShippingMethod] AssertStoreFrontShippingMethodUnavailableActionGroup");
		$I->waitForElementNotVisible("//div[@id='checkout-shipping-method-load']//td[contains(., 'Free Shipping')]/..", 30); // stepKey: waitForShippingMethodNotVisibleDontFreeShippingMethod
		$I->dontSeeElement("//div[@id='checkout-shipping-method-load']//td[contains(., 'Free Shipping')]/.."); // stepKey: dontSeeShippingMethodDontFreeShippingMethod
		$I->comment("Exiting Action Group [dontFreeShippingMethod] AssertStoreFrontShippingMethodUnavailableActionGroup");
		$I->comment("Assert no quotes message");
		$I->comment("Entering Action Group [assertNoQuotesMessage] AssertStoreFrontNoQuotesMessageActionGroup");
		$I->waitForElementVisible("#checkout-step-shipping_method div", 30); // stepKey: waitForNoQuotesMsgVisibleAssertNoQuotesMessage
		$I->see("Sorry, no quotes are available for this order at this time", "#checkout-step-shipping_method div"); // stepKey: assertNoQuotesMessageAssertNoQuotesMessage
		$I->comment("Exiting Action Group [assertNoQuotesMessage] AssertStoreFrontNoQuotesMessageActionGroup");
		$I->comment("Assert Next button");
		$I->dontSeeElement("button.button.action.continue.primary"); // stepKey: dontSeeNextButton
		$I->waitForPageLoad(30); // stepKey: dontSeeNextButtonWaitForPageLoad
		$I->comment("Fill form with valid data for US > California");
		$I->selectOption("select[name=country_id]", "United States"); // stepKey: selectCountry
		$I->selectOption("select[name=region_id]", "California"); // stepKey: selectState
		$I->fillField("input[name=postcode]", "90001"); // stepKey: fillPostcode
		$I->comment("Assert shipping methods are unavailable for US > California");
		$I->comment("Entering Action Group [dontSeeFlatRateShippingMtd] AssertStoreFrontShippingMethodUnavailableActionGroup");
		$I->waitForElementNotVisible("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..", 30); // stepKey: waitForShippingMethodNotVisibleDontSeeFlatRateShippingMtd
		$I->dontSeeElement("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/.."); // stepKey: dontSeeShippingMethodDontSeeFlatRateShippingMtd
		$I->comment("Exiting Action Group [dontSeeFlatRateShippingMtd] AssertStoreFrontShippingMethodUnavailableActionGroup");
		$I->comment("Entering Action Group [dontFreeShippingMtd] AssertStoreFrontShippingMethodUnavailableActionGroup");
		$I->waitForElementNotVisible("//div[@id='checkout-shipping-method-load']//td[contains(., 'Free Shipping')]/..", 30); // stepKey: waitForShippingMethodNotVisibleDontFreeShippingMtd
		$I->dontSeeElement("//div[@id='checkout-shipping-method-load']//td[contains(., 'Free Shipping')]/.."); // stepKey: dontSeeShippingMethodDontFreeShippingMtd
		$I->comment("Exiting Action Group [dontFreeShippingMtd] AssertStoreFrontShippingMethodUnavailableActionGroup");
		$I->comment("Assert no quotes message for US > California");
		$I->comment("Entering Action Group [assertNoQuotesMsg] AssertStoreFrontNoQuotesMessageActionGroup");
		$I->waitForElementVisible("#checkout-step-shipping_method div", 30); // stepKey: waitForNoQuotesMsgVisibleAssertNoQuotesMsg
		$I->see("Sorry, no quotes are available for this order at this time", "#checkout-step-shipping_method div"); // stepKey: assertNoQuotesMessageAssertNoQuotesMsg
		$I->comment("Exiting Action Group [assertNoQuotesMsg] AssertStoreFrontNoQuotesMessageActionGroup");
		$I->comment("Assert Next button for US > California");
		$I->dontSeeElement("button.button.action.continue.primary"); // stepKey: dontSeeNextBtn
		$I->waitForPageLoad(30); // stepKey: dontSeeNextBtnWaitForPageLoad
		$I->comment("Fill form for specific country - Afghanistan");
		$I->selectOption("select[name=country_id]", "Afghanistan"); // stepKey: selectSpecificCountry
		$I->comment("Assert shipping methods are available");
		$I->comment("Entering Action Group [seeFlatRateShippingMethod] AssertStoreFrontShippingMethodAvailableActionGroup");
		$I->waitForElementVisible("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..", 30); // stepKey: waitForShippingMethodLoadSeeFlatRateShippingMethod
		$I->seeElement("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/.."); // stepKey: seeShippingMethodSeeFlatRateShippingMethod
		$I->comment("Exiting Action Group [seeFlatRateShippingMethod] AssertStoreFrontShippingMethodAvailableActionGroup");
		$I->comment("Entering Action Group [seeFreeShippingMethod] AssertStoreFrontShippingMethodAvailableActionGroup");
		$I->waitForElementVisible("//div[@id='checkout-shipping-method-load']//td[contains(., 'Free Shipping')]/..", 30); // stepKey: waitForShippingMethodLoadSeeFreeShippingMethod
		$I->seeElement("//div[@id='checkout-shipping-method-load']//td[contains(., 'Free Shipping')]/.."); // stepKey: seeShippingMethodSeeFreeShippingMethod
		$I->comment("Exiting Action Group [seeFreeShippingMethod] AssertStoreFrontShippingMethodAvailableActionGroup");
		$I->comment("Assert Next button is available");
		$I->seeElement("button.button.action.continue.primary"); // stepKey: seeNextButton
		$I->waitForPageLoad(30); // stepKey: seeNextButtonWaitForPageLoad
	}
}
