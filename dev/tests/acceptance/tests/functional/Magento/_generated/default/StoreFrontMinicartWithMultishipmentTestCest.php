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
 * @Title("MC-18519: Checking multi shipment with multiple shipment at minicart from checkout")
 * @Description("Shipping price shows 0 when you return from multiple checkout to cart<h3>Test files</h3>app/code/Magento/Multishipping/Test/Mftf/Test/StoreFrontMinicartWithMultishipmentTest.xml<br>")
 * @TestCaseId("MC-18519")
 * @group Multishipment
 */
class StoreFrontMinicartWithMultishipmentTestCest
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
		$I->comment("Entering Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomer
		$I->comment("Exiting Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("product1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("product2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
		$I->createEntity("disableFreeShipping", "hook", "FreeShippinMethodDefault", [], []); // stepKey: disableFreeShipping
		$I->comment("Entering Action Group [logoutAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAdmin
		$I->comment("Exiting Action Group [logoutAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"Checking multi shipment with multiple shipment at minicart from checkout"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StoreFrontMinicartWithMultishipmentTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [checkoutWithMultipleAddresses] CheckingWithMultipleAddressesActionGroup");
		$I->click("//span[text()='Check Out with Multiple Addresses']"); // stepKey: clickOnCheckoutWithMultipleAddressesCheckoutWithMultipleAddresses
		$I->waitForPageLoad(30); // stepKey: waitForMultipleAddressPageLoadCheckoutWithMultipleAddresses
		$firstShippingAddressValueCheckoutWithMultipleAddresses = $I->grabTextFrom("#multiship-addresses-table tbody tr:nth-of-type(1) .col.address select option:nth-of-type(1)"); // stepKey: firstShippingAddressValueCheckoutWithMultipleAddresses
		$I->selectOption("//tr[position()=1]//td[@data-th='Send To']//select", $firstShippingAddressValueCheckoutWithMultipleAddresses); // stepKey: selectFirstShippingMethodCheckoutWithMultipleAddresses
		$I->waitForPageLoad(30); // stepKey: waitForSecondShippingAddressesCheckoutWithMultipleAddresses
		$secondShippingAddressValueCheckoutWithMultipleAddresses = $I->grabTextFrom("#multiship-addresses-table tbody tr:nth-of-type(2) .col.address select option:nth-of-type(2)"); // stepKey: secondShippingAddressValueCheckoutWithMultipleAddresses
		$I->selectOption("//tr[position()=2]//td[@data-th='Send To']//select", $secondShippingAddressValueCheckoutWithMultipleAddresses); // stepKey: selectSecondShippingMethodCheckoutWithMultipleAddresses
		$I->click("//button[@class='action update']"); // stepKey: clickOnUpdateAddressCheckoutWithMultipleAddresses
		$I->waitForPageLoad(30); // stepKey: waitForShippingInformationCheckoutWithMultipleAddresses
		$I->click("//span[text()='Go to Shipping Information']"); // stepKey: goToShippingInformationCheckoutWithMultipleAddresses
		$I->waitForPageLoad(30); // stepKey: waitForShippingPageLoadCheckoutWithMultipleAddresses
		$I->comment("Exiting Action Group [checkoutWithMultipleAddresses] CheckingWithMultipleAddressesActionGroup");
		$I->comment("Entering Action Group [checkoutWithMultipleShipping] SelectMultiShippingInfoActionGroup");
		$I->selectOption("//div[@class='block block-shipping'][position()=1]//dd[position()=1]//input[@class='radio']", "Fixed"); // stepKey: selectShippingMethod1CheckoutWithMultipleShipping
		$I->waitForPageLoad(5); // stepKey: selectShippingMethod1CheckoutWithMultipleShippingWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSecondShippingMethodCheckoutWithMultipleShipping
		$I->selectOption("//div[@class='block block-shipping'][position()=2]//dd[position()=2]//input[@class='radio']", "Free"); // stepKey: selectShippingMethod2CheckoutWithMultipleShipping
		$I->waitForPageLoad(5); // stepKey: selectShippingMethod2CheckoutWithMultipleShippingWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForRadioOptionsCheckoutWithMultipleShipping
		$I->click(".action.primary.continue"); // stepKey: goToBillingInformationCheckoutWithMultipleShipping
		$I->comment("Exiting Action Group [checkoutWithMultipleShipping] SelectMultiShippingInfoActionGroup");
		$I->comment("Entering Action Group [checkoutWithPaymentMethod] SelectBillingInfoActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForBillingInfoPageLoadCheckoutWithPaymentMethod
		$I->click("#payment-continue"); // stepKey: goToReviewOrderCheckoutWithPaymentMethod
		$I->waitForPageLoad(30); // stepKey: goToReviewOrderCheckoutWithPaymentMethodWaitForPageLoad
		$I->comment("Exiting Action Group [checkoutWithPaymentMethod] SelectBillingInfoActionGroup");
		$I->comment("Entering Action Group [reviewOrderForMultiShipment] ReviewOrderForMultiShipmentActionGroup");
		$I->comment("Check First Shipping Method Price");
		$firstShippingMethodBasePriceReviewOrderForMultiShipment = $I->grabTextFrom("//div[@class='block-content'][position()=1]//div[@class='box box-shipping-method'][position()=1]//span[@class='price']"); // stepKey: firstShippingMethodBasePriceReviewOrderForMultiShipment
		$firstShippingMethodSubtotalPriceReviewOrderForMultiShipment = $I->grabTextFrom("//div[@class='block-content'][position()=1]//td[@class='amount'][contains(@data-th,'Shipping & Handling')]//span[@class='price']"); // stepKey: firstShippingMethodSubtotalPriceReviewOrderForMultiShipment
		$I->assertEquals("$firstShippingMethodSubtotalPriceReviewOrderForMultiShipment", "$firstShippingMethodBasePriceReviewOrderForMultiShipment"); // stepKey: assertShippingMethodPriceReviewOrderForMultiShipment
		$I->comment("Check Second Shipping Method Price");
		$secondShippingMethodBasePriceReviewOrderForMultiShipment = $I->grabTextFrom("//div[@class='block-content'][position()=2]//div[@class='box box-shipping-method'][position()=1]//span[@class='price']"); // stepKey: secondShippingMethodBasePriceReviewOrderForMultiShipment
		$secondShippingMethodSubtotalPriceReviewOrderForMultiShipment = $I->grabTextFrom("//div[@class='block-content'][position()=2]//td[@class='amount'][contains(@data-th,'Shipping & Handling')]//span[@class='price']"); // stepKey: secondShippingMethodSubtotalPriceReviewOrderForMultiShipment
		$I->assertEquals("$secondShippingMethodSubtotalPriceReviewOrderForMultiShipment", "$secondShippingMethodBasePriceReviewOrderForMultiShipment"); // stepKey: assertSecondShippingMethodPriceReviewOrderForMultiShipment
		$I->comment("Exiting Action Group [reviewOrderForMultiShipment] ReviewOrderForMultiShipmentActionGroup");
		$I->amOnPage("/checkout/cart/index/"); // stepKey: amOnCheckoutCartIndexPage
		$I->comment("Entering Action Group [openCartAgain] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageOpenCartAgain
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartOpenCartAgain
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartOpenCartAgainWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkOpenCartAgain
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkOpenCartAgainWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartOpenCartAgain
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartOpenCartAgainWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartOpenCartAgain
		$I->waitForPageLoad(30); // stepKey: clickCartOpenCartAgainWaitForPageLoad
		$I->comment("Exiting Action Group [openCartAgain] StorefrontOpenCartFromMinicartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForMinicartPageLoad
		$I->comment("Entering Action Group [checkoutWithMinicart] CheckingWithMinicartActionGroup");
		$I->click("//div[@class='title']"); // stepKey: clickOnCollapsibleDivCheckoutWithMinicart
		$I->click("//input[@class='radio'][position()=1]"); // stepKey: clickOnShippingMethodRadioButtonCheckoutWithMinicart
		$I->waitForPageLoad(30); // stepKey: waitForShippingPriceToBeChangedCheckoutWithMinicart
		$shippingMethodRadioTextCheckoutWithMinicart = $I->grabTextFrom("//label[@class='label'][position()=1]//span//span"); // stepKey: shippingMethodRadioTextCheckoutWithMinicart
		$shippingMethodSubtotalPriceCheckoutWithMinicart = $I->grabTextFrom("//tr[@class='totals shipping excl']//td[@class='amount']//span"); // stepKey: shippingMethodSubtotalPriceCheckoutWithMinicart
		$I->assertEquals("$shippingMethodSubtotalPriceCheckoutWithMinicart", "$shippingMethodRadioTextCheckoutWithMinicart"); // stepKey: assertShippingMethodPriceCheckoutWithMinicart
		$I->comment("Exiting Action Group [checkoutWithMinicart] CheckingWithMinicartActionGroup");
	}
}
