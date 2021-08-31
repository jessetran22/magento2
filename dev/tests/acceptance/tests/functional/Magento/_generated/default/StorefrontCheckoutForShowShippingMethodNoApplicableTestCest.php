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
 * @Title("MC-37420: Storefront checkout for not applicable shipping method test")
 * @Description("Checkout flow if shipping rates are not applicable<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCheckoutForShowShippingMethodNoApplicableTest.xml<br>")
 * @TestCaseId("MC-37420")
 * @group checkout
 */
class StorefrontCheckoutForShowShippingMethodNoApplicableTestCest
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
		$I->comment("Enable flat rate shipping to specific country -  Afghanistan");
		$enableFlatRate = $I->magentoCLI("config:set carriers/flatrate/active 1", 60); // stepKey: enableFlatRate
		$I->comment($enableFlatRate);
		$allowFlatRateSpecificCountries = $I->magentoCLI("config:set carriers/flatrate/sallowspecific 1", 60); // stepKey: allowFlatRateSpecificCountries
		$I->comment($allowFlatRateSpecificCountries);
		$enableFlatRateToAfghanistan = $I->magentoCLI("config:set carriers/flatrate/specificcountry AF", 60); // stepKey: enableFlatRateToAfghanistan
		$I->comment($enableFlatRateToAfghanistan);
		$I->comment("Enable Show Method if Not Applicable");
		$enableShowMethodNoApplicable = $I->magentoCLI("config:set carriers/flatrate/showmethod 1", 60); // stepKey: enableShowMethodNoApplicable
		$I->comment($enableShowMethodNoApplicable);
		$I->comment("Create Customer with filled Shipping & Billing Address");
		$I->createEntity("createCustomer", "hook", "CustomerEntityOne", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logoutFromStorefront] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutFromStorefront
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutFromStorefront
		$I->comment("Exiting Action Group [logoutFromStorefront] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$allowFlatRateToAllCountries = $I->magentoCLI("config:set carriers/flatrate/sallowspecific 0", 60); // stepKey: allowFlatRateToAllCountries
		$I->comment($allowFlatRateToAllCountries);
		$disableShowMethodNoApplicable = $I->magentoCLI("config:set carriers/flatrate/showmethod 0", 60); // stepKey: disableShowMethodNoApplicable
		$I->comment($disableShowMethodNoApplicable);
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
	 * @Stories({"Checkout for not applicable shipping method"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Features({"Checkout"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckoutForShowShippingMethodNoApplicableTest(AcceptanceTester $I)
	{
		$I->comment("Login with created Customer");
		$I->comment("Entering Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginAsCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginAsCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsCustomer
		$I->comment("Exiting Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
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
		$I->comment("Assert shipping price for US > California");
		$I->dontSeeElement("//*[@id='checkout-shipping-method-load']//td[@class='col col-price']"); // stepKey: dontSeePrice
		$I->comment("Assert Next button is available");
		$I->seeElement("button.button.action.continue.primary"); // stepKey: seeNextButton
		$I->waitForPageLoad(30); // stepKey: seeNextButtonWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextButton
		$I->waitForPageLoad(30); // stepKey: clickNextButtonWaitForPageLoad
		$I->comment("Assert order cannot be placed and error message will shown.");
		$I->waitForPageLoad(30); // stepKey: waitForError
		$I->seeElementInDOM("//div[contains(@class, 'message message-error error')]//div[contains(text(), 'The shipping method is missing. Select the shipping method and try again')]"); // stepKey: seeShippingMethodError
	}
}
