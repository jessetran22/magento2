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
 * @Title("MC-20613: Free Shipping Minimum Order Amount Excluding/Including Tax options")
 * @Description("Free Shipping Minimum Order Amount Excluding/Including Tax options<h3>Test files</h3>app/code/Magento/OfflineShipping/Test/Mftf/Test/StorefrontFreeShippingDisplayWithInclTaxOptionTest.xml<br>")
 * @TestCaseId("MC-20613")
 * @group shipping
 */
class StorefrontFreeShippingDisplayWithInclTaxOptionTestCest
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
		$createSimpleProductFields['price'] = "100.00";
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], $createSimpleProductFields); // stepKey: createSimpleProduct
		$I->comment("Enable free shipping method");
		$I->createEntity("enableFreeShippingMethod", "hook", "FreeShippinMethodConfig", [], []); // stepKey: enableFreeShippingMethod
		$I->createEntity("setFreeShippingSubtotal", "hook", "setFreeShippingSubtotal", [], []); // stepKey: setFreeShippingSubtotal
		$I->createEntity("setTaxIncluding", "hook", "SetTaxIncluding", [], []); // stepKey: setTaxIncluding
		$I->comment("Tax configuration (Store>Configuration; Sales>Tax)");
		$I->createEntity("configureTaxForCA", "hook", "Tax_Config_CA", [], []); // stepKey: configureTaxForCA
		$I->createEntity("createTaxRule", "hook", "defaultTaxRule", [], []); // stepKey: createTaxRule
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Disable free shipping method");
		$I->createEntity("disableFreeShippingMethod", "hook", "FreeShippinMethodDefault", [], []); // stepKey: disableFreeShippingMethod
		$I->createEntity("setFreeShippingSubtotalToDefault", "hook", "setFreeShippingSubtotalToDefault", [], []); // stepKey: setFreeShippingSubtotalToDefault
		$I->createEntity("setTaxIncludingToDefault", "hook", "SetTaxIncludingToDefault", [], []); // stepKey: setTaxIncludingToDefault
		$I->deleteEntity("createTaxRule", "hook"); // stepKey: deleteTaxRule
		$I->createEntity("resetTaxConfiguration", "hook", "DefaultTaxConfig", [], []); // stepKey: resetTaxConfiguration
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
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
	 * @Features({"OfflineShipping"})
	 * @Stories({"Offline Shipping Methods"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontFreeShippingDisplayWithInclTaxOptionTest(AcceptanceTester $I)
	{
		$I->comment("Add simple product to cart");
		$I->comment("Entering Action Group [addProductToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] AddSimpleProductToCartActionGroup");
		$I->comment("Assert that taxes are applied correctly for CA");
		$I->comment("Entering Action Group [goToCheckout] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCheckout
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCheckout
		$I->comment("Exiting Action Group [goToCheckout] StorefrontCartPageOpenActionGroup");
		$I->waitForElementVisible("[data-th='Tax'] span", 30); // stepKey: waitForOverviewVisible
		$I->waitForPageLoad(30); // stepKey: waitForOverviewVisibleWaitForPageLoad
		$I->waitForElement("#shipping-zip-form", 30); // stepKey: waitForEstimateShippingAndTaxForm
		$I->waitForElement("#co-shipping-method-form", 30); // stepKey: waitForShippingMethodForm
		$I->conditionalClick("#block-shipping-heading", "select[name='country_id']", false); // stepKey: expandEstimateShippingandTax
		$I->waitForPageLoad(10); // stepKey: expandEstimateShippingandTaxWaitForPageLoad
		$I->selectOption("select[name='country_id']", "United States"); // stepKey: selectUSCountry
		$I->waitForPageLoad(10); // stepKey: selectUSCountryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSelectCountry
		$I->selectOption("select[name='region_id']", "California"); // stepKey: selectCaliforniaRegion
		$I->waitForPageLoad(10); // stepKey: selectCaliforniaRegionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSelectRegion
		$I->see("$8.25", "[data-th='Tax'] span"); // stepKey: seeTaxForCA
		$I->waitForPageLoad(30); // stepKey: seeTaxForCAWaitForPageLoad
		$I->comment("See available Free Shipping option");
		$I->comment("Entering Action Group [assertShippingMethodLabel] StorefrontAssertShippingMethodPresentInCartActionGroup");
		$I->see("Free Shipping", "#co-shipping-method-form dl dt span"); // stepKey: assertShippingMethodIsPresentInCartAssertShippingMethodLabel
		$I->comment("Exiting Action Group [assertShippingMethodLabel] StorefrontAssertShippingMethodPresentInCartActionGroup");
		$I->comment("Change State to New York");
		$I->selectOption("select[name='region_id']", "New York"); // stepKey: selectAnotherState
		$I->waitForPageLoad(10); // stepKey: selectAnotherStateWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethodLoad
		$I->dontSee("Free Shipping", "#co-shipping-method-form dl dt span"); // stepKey: assertShippingMethodIsNotPresentInCart
	}
}
