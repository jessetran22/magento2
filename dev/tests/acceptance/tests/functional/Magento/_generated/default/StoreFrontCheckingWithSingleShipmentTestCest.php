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
 * @Title("MC-18519: Checking multi shipment with single shipment adresses on front end order page")
 * @Description("Shipping price shows 0 when you return from multiple checkout to cart<h3>Test files</h3>app/code/Magento/Multishipping/Test/Mftf/Test/StoreFrontCheckingWithSingleShipmentTest.xml<br>")
 * @TestCaseId("MC-18519")
 * @group Multishipment
 */
class StoreFrontCheckingWithSingleShipmentTestCest
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
		$I->createEntity("category", "hook", "SimpleSubCategory", [], []); // stepKey: category
		$I->createEntity("product1", "hook", "SimpleProduct", ["category"], []); // stepKey: product1
		$I->createEntity("product2", "hook", "SimpleProduct", ["category"], []); // stepKey: product2
		$I->createEntity("customer", "hook", "Simple_US_Customer_Two_Addresses", [], []); // stepKey: customer
		$I->createEntity("enableFreeShipping", "hook", "FreeShippinMethodConfig", [], []); // stepKey: enableFreeShipping
		$I->createEntity("enableFlatRateShipping", "hook", "FlatRateShippingMethodConfig", [], []); // stepKey: enableFlatRateShipping
		$I->comment("Entering Action Group [enableCheckMoneyOrderPaymentMethod] CliEnableCheckMoneyOrderPaymentMethodActionGroup");
		$enableCheckMoneyOrderPaymentMethodEnableCheckMoneyOrderPaymentMethod = $I->magentoCLI("config:set payment/checkmo/active 1", 60); // stepKey: enableCheckMoneyOrderPaymentMethodEnableCheckMoneyOrderPaymentMethod
		$I->comment($enableCheckMoneyOrderPaymentMethodEnableCheckMoneyOrderPaymentMethod);
		$I->comment("Exiting Action Group [enableCheckMoneyOrderPaymentMethod] CliEnableCheckMoneyOrderPaymentMethodActionGroup");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccount
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccount
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'hook')); // stepKey: fillEmailLoginToStorefrontAccount
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'hook')); // stepKey: fillPasswordLoginToStorefrontAccount
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccount
		$I->comment("Exiting Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("product1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("product2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
		$I->createEntity("disableFreeShipping", "hook", "FreeShippinMethodDefault", [], []); // stepKey: disableFreeShipping
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Features({"Multishipping"})
	 * @Stories({"Checking multi shipment with single shipment adresses on front end order page"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StoreFrontCheckingWithSingleShipmentTest(AcceptanceTester $I)
	{
		$I->amOnPage($I->retrieveEntityField('product1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProduct1
		$I->comment("Entering Action Group [addToCartFromStorefrontProduct1] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProduct1
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProduct1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProduct1
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProduct1
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProduct1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProduct1
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProduct1
		$I->see("You added " . $I->retrieveEntityField('product1', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProduct1
		$I->comment("Exiting Action Group [addToCartFromStorefrontProduct1] AddToCartFromStorefrontProductPageActionGroup");
		$I->amOnPage($I->retrieveEntityField('product2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProduct2
		$I->comment("Entering Action Group [addToCartFromStorefrontProduct2] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProduct2
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProduct2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProduct2
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProduct2
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProduct2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProduct2
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProduct2
		$I->see("You added " . $I->retrieveEntityField('product2', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProduct2
		$I->comment("Exiting Action Group [addToCartFromStorefrontProduct2] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [openCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageOpenCart
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartOpenCart
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartOpenCartWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkOpenCart
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkOpenCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartOpenCart
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartOpenCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartOpenCart
		$I->waitForPageLoad(30); // stepKey: clickCartOpenCartWaitForPageLoad
		$I->comment("Exiting Action Group [openCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->comment("Entering Action Group [checkoutWithSingleAddresses] CheckingWithSingleAddressActionGroup");
		$I->click("//span[text()='Check Out with Multiple Addresses']"); // stepKey: clickOnCheckoutWithMultipleAddressesCheckoutWithSingleAddresses
		$I->waitForPageLoad(30); // stepKey: waitForMultipleAddressPageLoadCheckoutWithSingleAddresses
		$I->click("//span[text()='Go to Shipping Information']"); // stepKey: goToShippingInformationCheckoutWithSingleAddresses
		$I->waitForPageLoad(30); // stepKey: waitForShippingPageLoadCheckoutWithSingleAddresses
		$I->comment("Exiting Action Group [checkoutWithSingleAddresses] CheckingWithSingleAddressActionGroup");
		$I->comment("Entering Action Group [checkoutWithSingleShipping] SelectSingleShippingInfoActionGroup");
		$I->selectOption("//input[@class='radio']", "Fixed"); // stepKey: selectShippingMethodCheckoutWithSingleShipping
		$I->waitForPageLoad(30); // stepKey: waitForRadioOptionsCheckoutWithSingleShipping
		$I->click(".action.primary.continue"); // stepKey: goToBillingInformationCheckoutWithSingleShipping
		$I->comment("Exiting Action Group [checkoutWithSingleShipping] SelectSingleShippingInfoActionGroup");
		$I->comment("Entering Action Group [checkoutWithPaymentMethod] SelectBillingInfoActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForBillingInfoPageLoadCheckoutWithPaymentMethod
		$I->click("#payment-continue"); // stepKey: goToReviewOrderCheckoutWithPaymentMethod
		$I->waitForPageLoad(30); // stepKey: goToReviewOrderCheckoutWithPaymentMethodWaitForPageLoad
		$I->comment("Exiting Action Group [checkoutWithPaymentMethod] SelectBillingInfoActionGroup");
		$I->comment("Entering Action Group [reviewOrderForSingleShipment] ReviewOrderForSingleShipmentActionGroup");
		$shippingMethodBasePriceReviewOrderForSingleShipment = $I->grabTextFrom("//div[@class='block-content'][position()=1]//div[@class='box box-shipping-method'][position()=1]//span[@class='price']"); // stepKey: shippingMethodBasePriceReviewOrderForSingleShipment
		$shippingMethodSubtotalPriceReviewOrderForSingleShipment = $I->grabTextFrom("//div[@class='block-content'][position()=1]//td[@class='amount'][contains(@data-th,'Shipping & Handling')]//span[@class='price']"); // stepKey: shippingMethodSubtotalPriceReviewOrderForSingleShipment
		$I->assertEquals("$shippingMethodSubtotalPriceReviewOrderForSingleShipment", "$shippingMethodBasePriceReviewOrderForSingleShipment"); // stepKey: assertShippingMethodPriceReviewOrderForSingleShipment
		$I->comment("Exiting Action Group [reviewOrderForSingleShipment] ReviewOrderForSingleShipmentActionGroup");
		$I->comment("Entering Action Group [placeOrder] PlaceOrderActionGroup");
		$I->click("#review-button"); // stepKey: checkoutMultiShipmentPlaceOrderPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForSuccessfullyPlacedOrderPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceOrder
		$I->comment("Exiting Action Group [placeOrder] PlaceOrderActionGroup");
	}
}
