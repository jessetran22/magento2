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
 * @Title("MC-28900: Verify Shipping price for Storefront after multiple address checkout")
 * @Description("Verify that shipping price on My account matches with shipping method prices after multiple addresses checkout (Order view page)<h3>Test files</h3>app/code/Magento/Multishipping/Test/Mftf/Test/StorefrontOrderWithMultishippingTest.xml<br>")
 * @TestCaseId("MC-28900")
 * @group catalog
 * @group sales
 * @group multishipping
 */
class StorefrontOrderWithMultishippingTestCest
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
		$I->createEntity("createProduct1", "hook", "SimpleProduct2", [], []); // stepKey: createProduct1
		$I->createEntity("createProduct2", "hook", "SimpleProduct2", [], []); // stepKey: createProduct2
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_Two_Addresses", [], []); // stepKey: createCustomer
		$I->comment("Set configurations");
		$I->comment("Entering Action Group [enableFreeShipping] CliEnableFreeShippingMethodActionGroup");
		$enableFreeShippingMethodEnableFreeShipping = $I->magentoCLI("config:set carriers/freeshipping/active 1", 60); // stepKey: enableFreeShippingMethodEnableFreeShipping
		$I->comment($enableFreeShippingMethodEnableFreeShipping);
		$I->comment("Exiting Action Group [enableFreeShipping] CliEnableFreeShippingMethodActionGroup");
		$I->comment("Entering Action Group [enableFlatRateShipping] CliEnableFlatRateShippingMethodActionGroup");
		$enableFlatRateShippingMethodEnableFlatRateShipping = $I->magentoCLI("config:set carriers/flatrate/active 1", 60); // stepKey: enableFlatRateShippingMethodEnableFlatRateShipping
		$I->comment($enableFlatRateShippingMethodEnableFlatRateShipping);
		$I->comment("Exiting Action Group [enableFlatRateShipping] CliEnableFlatRateShippingMethodActionGroup");
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
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'hook')); // stepKey: fillEmailLoginToStorefrontAccount
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'hook')); // stepKey: fillPasswordLoginToStorefrontAccount
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
		$I->deleteEntity("createProduct1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("createProduct2", "hook"); // stepKey: deleteProduct2
		$I->comment("Need logout before customer delete. Fatal error appears otherwise");
		$I->comment("Entering Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [disableFreeShipping] CliDisableFreeShippingMethodActionGroup");
		$disableFreeShippingMethodDisableFreeShipping = $I->magentoCLI("config:set carriers/freeshipping/active 0", 60); // stepKey: disableFreeShippingMethodDisableFreeShipping
		$I->comment($disableFreeShippingMethodDisableFreeShipping);
		$I->comment("Exiting Action Group [disableFreeShipping] CliDisableFreeShippingMethodActionGroup");
		$I->comment("Entering Action Group [clearAllOrdersGridFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: goToGridOrdersPageClearAllOrdersGridFilters
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClearAllOrdersGridFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header .admin__data-grid-filters-current._show", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearAllOrdersGridFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitAfterClearFiltersClearAllOrdersGridFilters
		$I->comment("Exiting Action Group [clearAllOrdersGridFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"Shipping price shows 0 on Order view page after multiple address checkout"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontOrderWithMultishippingTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [addSimpleProduct1ToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddSimpleProduct1ToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddSimpleProduct1ToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddSimpleProduct1ToCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddSimpleProduct1ToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddSimpleProduct1ToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddSimpleProduct1ToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddSimpleProduct1ToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSimpleProduct1ToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddSimpleProduct1ToCart
		$I->see("You added " . $I->retrieveEntityField('createProduct1', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddSimpleProduct1ToCart
		$I->comment("Exiting Action Group [addSimpleProduct1ToCart] AddSimpleProductToCartActionGroup");
		$I->comment("Entering Action Group [addSimpleProduct2ToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddSimpleProduct2ToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddSimpleProduct2ToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddSimpleProduct2ToCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddSimpleProduct2ToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddSimpleProduct2ToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddSimpleProduct2ToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddSimpleProduct2ToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSimpleProduct2ToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddSimpleProduct2ToCart
		$I->see("You added " . $I->retrieveEntityField('createProduct2', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddSimpleProduct2ToCart
		$I->comment("Exiting Action Group [addSimpleProduct2ToCart] AddSimpleProductToCartActionGroup");
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
		$I->waitForPageLoad(30); // stepKey: waitForShippingInfoPageLoad
		$I->comment("Entering Action Group [checkoutWithMultipleShipping] SelectMultiShippingInfoActionGroup");
		$I->selectOption("//div[@class='block block-shipping'][position()=1]//dd[position()=1]//input[@class='radio']", "Fixed"); // stepKey: selectShippingMethod1CheckoutWithMultipleShipping
		$I->waitForPageLoad(5); // stepKey: selectShippingMethod1CheckoutWithMultipleShippingWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSecondShippingMethodCheckoutWithMultipleShipping
		$I->selectOption("//div[@class='block block-shipping'][position()=2]//dd[position()=2]//input[@class='radio']", "Free"); // stepKey: selectShippingMethod2CheckoutWithMultipleShipping
		$I->waitForPageLoad(5); // stepKey: selectShippingMethod2CheckoutWithMultipleShippingWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForRadioOptionsCheckoutWithMultipleShipping
		$I->click(".action.primary.continue"); // stepKey: goToBillingInformationCheckoutWithMultipleShipping
		$I->comment("Exiting Action Group [checkoutWithMultipleShipping] SelectMultiShippingInfoActionGroup");
		$I->comment("Select Check / Money order Payment method");
		$I->comment("Entering Action Group [selectCheckMoneyPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectCheckMoneyPayment
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectCheckMoneyPayment
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectCheckMoneyPayment
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectCheckMoneyPayment
		$I->comment("Exiting Action Group [selectCheckMoneyPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Entering Action Group [checkoutWithPaymentMethod] SelectBillingInfoActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForBillingInfoPageLoadCheckoutWithPaymentMethod
		$I->click("#payment-continue"); // stepKey: goToReviewOrderCheckoutWithPaymentMethod
		$I->waitForPageLoad(30); // stepKey: goToReviewOrderCheckoutWithPaymentMethodWaitForPageLoad
		$I->comment("Exiting Action Group [checkoutWithPaymentMethod] SelectBillingInfoActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForReviewOrderPageLoad
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
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderPageLoad
		$I->comment("Entering Action Group [placeOrder] StorefrontPlaceOrderForMultipleAddressesActionGroup");
		$I->click("#review-button"); // stepKey: checkoutMultiShipmentPlaceOrderPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForSuccessfullyPlacedOrderPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceOrder
		$getFirstOrderIdPlaceOrder = $I->grabTextFrom("//li[@class='shipping-list'][position()=1]//a"); // stepKey: getFirstOrderIdPlaceOrder
		$dataHrefForFirstOrderPlaceOrder = $I->grabAttributeFrom("//li[@class='shipping-list'][position()=1]//a", "href"); // stepKey: dataHrefForFirstOrderPlaceOrder
		$getSecondOrderIdPlaceOrder = $I->grabTextFrom("//li[@class='shipping-list'][position()=2]//a"); // stepKey: getSecondOrderIdPlaceOrder
		$dataHrefForSecondOrderPlaceOrder = $I->grabAttributeFrom("//li[@class='shipping-list'][position()=2]//a", "href"); // stepKey: dataHrefForSecondOrderPlaceOrder
		$I->comment("Exiting Action Group [placeOrder] StorefrontPlaceOrderForMultipleAddressesActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageLoad
		$I->comment("Check first order");
		$I->comment("Entering Action Group [openFirstOrder] StorefrontCustomerOrdersViewOrderActionGroup");
		$I->amOnPage("sales/order/history/"); // stepKey: openCustomerOrdersHistoryPageOpenFirstOrder
		$I->click("//td[contains(text(),'{$getFirstOrderIdPlaceOrder}')]/following-sibling::td[contains(@class,'col') and contains(@class,'actions')]/a[contains(@class, 'view')]"); // stepKey: clickViewOrderButtonOpenFirstOrder
		$I->waitForPageLoad(30); // stepKey: clickViewOrderButtonOpenFirstOrderWaitForPageLoad
		$I->comment("Exiting Action Group [openFirstOrder] StorefrontCustomerOrdersViewOrderActionGroup");
		$I->comment("Entering Action Group [checkFirstOrderTotals] AssertStorefrontCustomerOrderMatchesGrandTotalActionGroup");
		$grabValueForSubtotalCheckFirstOrderTotals = $I->grabTextFrom("//div[@class='order-details-items ordered']//tr[@class='subtotal']//td[@class='amount']//span[@class='price']"); // stepKey: grabValueForSubtotalCheckFirstOrderTotals
		$grabValueForShippingHandlingCheckFirstOrderTotals = $I->grabTextFrom("//div[@class='order-details-items ordered']//tr[@class='shipping']//td[@class='amount']//span[@class='price']"); // stepKey: grabValueForShippingHandlingCheckFirstOrderTotals
		$grabValueForGrandTotalCheckFirstOrderTotals = $I->grabTextFrom("//div[@class='order-details-items ordered']//tr[@class='grand_total']//td[@class='amount']//span[@class='price']"); // stepKey: grabValueForGrandTotalCheckFirstOrderTotals
		$grandTotalValueCheckFirstOrderTotals = $I->executeJS("             var grandTotal = '{$grabValueForGrandTotalCheckFirstOrderTotals}'.substr(1);             return (grandTotal);"); // stepKey: grandTotalValueCheckFirstOrderTotals
		$sumTotalValueCheckFirstOrderTotals = $I->executeJS("                var subtotal = '{$grabValueForSubtotalCheckFirstOrderTotals}'.substr(1);                var handling = '{$grabValueForShippingHandlingCheckFirstOrderTotals}'.substr(1);                var subtotalHandling = (parseFloat(subtotal) + parseFloat(handling)).toFixed(2);                return (subtotalHandling);"); // stepKey: sumTotalValueCheckFirstOrderTotals
		$I->assertEquals($sumTotalValueCheckFirstOrderTotals, $grandTotalValueCheckFirstOrderTotals); // stepKey: assertSubTotalPriceCheckFirstOrderTotals
		$I->comment("Exiting Action Group [checkFirstOrderTotals] AssertStorefrontCustomerOrderMatchesGrandTotalActionGroup");
		$I->comment("Check second order");
		$I->comment("Entering Action Group [openSecondOrder] StorefrontCustomerOrdersViewOrderActionGroup");
		$I->amOnPage("sales/order/history/"); // stepKey: openCustomerOrdersHistoryPageOpenSecondOrder
		$I->click("//td[contains(text(),'{$getSecondOrderIdPlaceOrder}')]/following-sibling::td[contains(@class,'col') and contains(@class,'actions')]/a[contains(@class, 'view')]"); // stepKey: clickViewOrderButtonOpenSecondOrder
		$I->waitForPageLoad(30); // stepKey: clickViewOrderButtonOpenSecondOrderWaitForPageLoad
		$I->comment("Exiting Action Group [openSecondOrder] StorefrontCustomerOrdersViewOrderActionGroup");
		$I->comment("Entering Action Group [checkSecondOrderTotals] AssertStorefrontCustomerOrderMatchesGrandTotalActionGroup");
		$grabValueForSubtotalCheckSecondOrderTotals = $I->grabTextFrom("//div[@class='order-details-items ordered']//tr[@class='subtotal']//td[@class='amount']//span[@class='price']"); // stepKey: grabValueForSubtotalCheckSecondOrderTotals
		$grabValueForShippingHandlingCheckSecondOrderTotals = $I->grabTextFrom("//div[@class='order-details-items ordered']//tr[@class='shipping']//td[@class='amount']//span[@class='price']"); // stepKey: grabValueForShippingHandlingCheckSecondOrderTotals
		$grabValueForGrandTotalCheckSecondOrderTotals = $I->grabTextFrom("//div[@class='order-details-items ordered']//tr[@class='grand_total']//td[@class='amount']//span[@class='price']"); // stepKey: grabValueForGrandTotalCheckSecondOrderTotals
		$grandTotalValueCheckSecondOrderTotals = $I->executeJS("             var grandTotal = '{$grabValueForGrandTotalCheckSecondOrderTotals}'.substr(1);             return (grandTotal);"); // stepKey: grandTotalValueCheckSecondOrderTotals
		$sumTotalValueCheckSecondOrderTotals = $I->executeJS("                var subtotal = '{$grabValueForSubtotalCheckSecondOrderTotals}'.substr(1);                var handling = '{$grabValueForShippingHandlingCheckSecondOrderTotals}'.substr(1);                var subtotalHandling = (parseFloat(subtotal) + parseFloat(handling)).toFixed(2);                return (subtotalHandling);"); // stepKey: sumTotalValueCheckSecondOrderTotals
		$I->assertEquals($sumTotalValueCheckSecondOrderTotals, $grandTotalValueCheckSecondOrderTotals); // stepKey: assertSubTotalPriceCheckSecondOrderTotals
		$I->comment("Exiting Action Group [checkSecondOrderTotals] AssertStorefrontCustomerOrderMatchesGrandTotalActionGroup");
		$I->comment("Assert order in orders grid");
		$I->comment("Go to order page");
		$I->comment("Entering Action Group [openFirstOrderPage] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageOpenFirstOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageOpenFirstOrderPage
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersOpenFirstOrderPage
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersOpenFirstOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersOpenFirstOrderPage
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersOpenFirstOrderPage
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersOpenFirstOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersOpenFirstOrderPage
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $getFirstOrderIdPlaceOrder); // stepKey: fillOrderIdFilterOpenFirstOrderPage
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersOpenFirstOrderPage
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersOpenFirstOrderPageWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageOpenFirstOrderPage
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageOpenFirstOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedOpenFirstOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersOpenFirstOrderPage
		$I->comment("Exiting Action Group [openFirstOrderPage] OpenOrderByIdActionGroup");
		$I->comment("Check status");
		$I->comment("Entering Action Group [seeFirstOrderPendingStatus] AdminOrderViewCheckStatusActionGroup");
		$I->see("Pending", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderStatusSeeFirstOrderPendingStatus
		$I->comment("Exiting Action Group [seeFirstOrderPendingStatus] AdminOrderViewCheckStatusActionGroup");
		$I->comment("Entering Action Group [validateOrderTotalsForFirstOrder] AdminSalesOrderActionGroup");
		$I->scrollTo(".order-subtotal-table tbody tr.col-0>td span.price"); // stepKey: scrollToOrderTotalSectionValidateOrderTotalsForFirstOrder
		$grabValueForSubtotalValidateOrderTotalsForFirstOrder = $I->grabTextFrom(".order-subtotal-table tbody tr.col-0>td span.price"); // stepKey: grabValueForSubtotalValidateOrderTotalsForFirstOrder
		$grabValueForShippingHandlingValidateOrderTotalsForFirstOrder = $I->grabTextFrom("//table[contains(@class, 'order-subtotal-table')]//td[normalize-space(.)='Shipping & Handling']/following-sibling::td//span[@class='price']"); // stepKey: grabValueForShippingHandlingValidateOrderTotalsForFirstOrder
		$grabValueForGrandTotalValidateOrderTotalsForFirstOrder = $I->grabTextFrom(".order-subtotal-table tfoot tr.col-0>td span.price"); // stepKey: grabValueForGrandTotalValidateOrderTotalsForFirstOrder
		$grandTotalValueValidateOrderTotalsForFirstOrder = $I->executeJS("         var grandTotal = '{$grabValueForGrandTotalValidateOrderTotalsForFirstOrder}'.substr(1);         return (grandTotal);"); // stepKey: grandTotalValueValidateOrderTotalsForFirstOrder
		$sumTotalValueValidateOrderTotalsForFirstOrder = $I->executeJS("                var subtotal = '{$grabValueForSubtotalValidateOrderTotalsForFirstOrder}'.substr(1);                var handling = '{$grabValueForShippingHandlingValidateOrderTotalsForFirstOrder}'.substr(1);                var subtotalHandling = (parseFloat(subtotal) + parseFloat(handling)).toFixed(2);                return (subtotalHandling);"); // stepKey: sumTotalValueValidateOrderTotalsForFirstOrder
		$I->assertEquals($sumTotalValueValidateOrderTotalsForFirstOrder, $grandTotalValueValidateOrderTotalsForFirstOrder); // stepKey: assertSubTotalPriceValidateOrderTotalsForFirstOrder
		$I->comment("Exiting Action Group [validateOrderTotalsForFirstOrder] AdminSalesOrderActionGroup");
		$I->comment("Go to order page");
		$I->comment("Entering Action Group [openSecondOrderPage] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageOpenSecondOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageOpenSecondOrderPage
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersOpenSecondOrderPage
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersOpenSecondOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersOpenSecondOrderPage
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersOpenSecondOrderPage
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersOpenSecondOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersOpenSecondOrderPage
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $getSecondOrderIdPlaceOrder); // stepKey: fillOrderIdFilterOpenSecondOrderPage
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersOpenSecondOrderPage
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersOpenSecondOrderPageWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageOpenSecondOrderPage
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageOpenSecondOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedOpenSecondOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersOpenSecondOrderPage
		$I->comment("Exiting Action Group [openSecondOrderPage] OpenOrderByIdActionGroup");
		$I->comment("Check status");
		$I->comment("Entering Action Group [seeSecondOrderPendingStatus] AdminOrderViewCheckStatusActionGroup");
		$I->see("Pending", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderStatusSeeSecondOrderPendingStatus
		$I->comment("Exiting Action Group [seeSecondOrderPendingStatus] AdminOrderViewCheckStatusActionGroup");
		$I->comment("Entering Action Group [validateOrderTotalsForSecondOrder] AdminSalesOrderActionGroup");
		$I->scrollTo(".order-subtotal-table tbody tr.col-0>td span.price"); // stepKey: scrollToOrderTotalSectionValidateOrderTotalsForSecondOrder
		$grabValueForSubtotalValidateOrderTotalsForSecondOrder = $I->grabTextFrom(".order-subtotal-table tbody tr.col-0>td span.price"); // stepKey: grabValueForSubtotalValidateOrderTotalsForSecondOrder
		$grabValueForShippingHandlingValidateOrderTotalsForSecondOrder = $I->grabTextFrom("//table[contains(@class, 'order-subtotal-table')]//td[normalize-space(.)='Shipping & Handling']/following-sibling::td//span[@class='price']"); // stepKey: grabValueForShippingHandlingValidateOrderTotalsForSecondOrder
		$grabValueForGrandTotalValidateOrderTotalsForSecondOrder = $I->grabTextFrom(".order-subtotal-table tfoot tr.col-0>td span.price"); // stepKey: grabValueForGrandTotalValidateOrderTotalsForSecondOrder
		$grandTotalValueValidateOrderTotalsForSecondOrder = $I->executeJS("         var grandTotal = '{$grabValueForGrandTotalValidateOrderTotalsForSecondOrder}'.substr(1);         return (grandTotal);"); // stepKey: grandTotalValueValidateOrderTotalsForSecondOrder
		$sumTotalValueValidateOrderTotalsForSecondOrder = $I->executeJS("                var subtotal = '{$grabValueForSubtotalValidateOrderTotalsForSecondOrder}'.substr(1);                var handling = '{$grabValueForShippingHandlingValidateOrderTotalsForSecondOrder}'.substr(1);                var subtotalHandling = (parseFloat(subtotal) + parseFloat(handling)).toFixed(2);                return (subtotalHandling);"); // stepKey: sumTotalValueValidateOrderTotalsForSecondOrder
		$I->assertEquals($sumTotalValueValidateOrderTotalsForSecondOrder, $grandTotalValueValidateOrderTotalsForSecondOrder); // stepKey: assertSubTotalPriceValidateOrderTotalsForSecondOrder
		$I->comment("Exiting Action Group [validateOrderTotalsForSecondOrder] AdminSalesOrderActionGroup");
	}
}
