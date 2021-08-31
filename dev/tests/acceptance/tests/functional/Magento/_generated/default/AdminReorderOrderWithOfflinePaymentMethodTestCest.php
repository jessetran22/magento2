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
 * @Title("MC-37495: Reorder Order from Admin for Offline Payment Methods")
 * @Description("Create reorder for order with two products and Check Money payment method<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminReorderOrderWithOfflinePaymentMethodTest.xml<br>")
 * @TestCaseId("MC-37495")
 * @group sales
 */
class AdminReorderOrderWithOfflinePaymentMethodTestCest
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
		$enableCheckMoneyOrder = $I->magentoCLI("config:set payment/checkmo/active 1", 60); // stepKey: enableCheckMoneyOrder
		$I->comment($enableCheckMoneyOrder);
		$I->createEntity("setDefaultFlatRateShippingMethod", "hook", "FlatRateShippingMethodDefault", [], []); // stepKey: setDefaultFlatRateShippingMethod
		$I->createEntity("createCustomer", "hook", "Simple_Customer_Without_Address", [], []); // stepKey: createCustomer
		$I->createEntity("createFirstSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createFirstSimpleProduct
		$I->createEntity("createSecondSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSecondSimpleProduct
		$I->createEntity("createCartForCustomer", "hook", "CustomerCart", ["createCustomer"], []); // stepKey: createCartForCustomer
		$I->createEntity("addFirstProductToCustomerCart", "hook", "CustomerCartItem", ["createCartForCustomer", "createFirstSimpleProduct"], []); // stepKey: addFirstProductToCustomerCart
		$I->createEntity("addSecondProductToCustomerCart", "hook", "CustomerCartItem", ["createCartForCustomer", "createSecondSimpleProduct"], []); // stepKey: addSecondProductToCustomerCart
		$I->createEntity("addCustomerOrderAddress", "hook", "CustomerAddressInformation", ["createCartForCustomer"], []); // stepKey: addCustomerOrderAddress
		$I->updateEntity("createCartForCustomer", "hook", "CustomerOrderPaymentMethod",["createCartForCustomer"]); // stepKey: sendCustomerPaymentInformation
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createFirstSimpleProduct", "hook"); // stepKey: deleteFirstSimpleProduct
		$I->deleteEntity("createSecondSimpleProduct", "hook"); // stepKey: deleteSecondSimpleProduct
		$I->comment("Entering Action Group [logoutFromAdminPanel] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdminPanel
		$I->comment("Exiting Action Group [logoutFromAdminPanel] AdminLogoutActionGroup");
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
	 * @Features({"Sales"})
	 * @Stories({"Reorder"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminReorderOrderWithOfflinePaymentMethodTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openOrderById] AdminOpenOrderByEntityIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/" . $I->retrieveEntityField('createCartForCustomer', 'return', 'test')); // stepKey: openOrderOpenOrderById
		$I->comment("Exiting Action Group [openOrderById] AdminOpenOrderByEntityIdActionGroup");
		$I->click("#order_reorder"); // stepKey: clickReorderButton
		$I->waitForPageLoad(30); // stepKey: clickReorderButtonWaitForPageLoad
		$I->comment("Entering Action Group [submitReorder] AdminOrderClickSubmitOrderActionGroup");
		$I->click("#submit_order_top_button"); // stepKey: clickSubmitOrderSubmitReorder
		$I->waitForPageLoad(30); // stepKey: clickSubmitOrderSubmitReorderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoadSubmitReorder
		$I->comment("Exiting Action Group [submitReorder] AdminOrderClickSubmitOrderActionGroup");
		$I->comment("Entering Action Group [verifyCreatedOrderInformation] VerifyCreatedOrderInformationActionGroup");
		$I->see("You created the order.", "div.message-success"); // stepKey: seeSuccessMessageVerifyCreatedOrderInformation
		$I->see("Pending", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderPendingStatusVerifyCreatedOrderInformation
		$getOrderIdVerifyCreatedOrderInformation = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: getOrderIdVerifyCreatedOrderInformation
		$I->assertNotEmpty($getOrderIdVerifyCreatedOrderInformation); // stepKey: assertOrderIdIsNotEmptyVerifyCreatedOrderInformation
		$I->comment("Exiting Action Group [verifyCreatedOrderInformation] VerifyCreatedOrderInformationActionGroup");
		$I->comment("Entering Action Group [verifyOrderAddressInformation] AssertOrderAddressInformationActionGroup");
		$I->see("11501 Domain Dr", ".order-billing-address address"); // stepKey: seeBillingAddressStreetVerifyOrderAddressInformation
		$I->see("Austin", ".order-billing-address address"); // stepKey: seeBillingAddressCityVerifyOrderAddressInformation
		$I->see("United States", ".order-billing-address address"); // stepKey: seeBillingCountryVerifyOrderAddressInformation
		$I->see("78758", ".order-billing-address address"); // stepKey: seeBillingAddressPostcodeVerifyOrderAddressInformation
		$I->see("11501 Domain Dr", ".order-shipping-address address"); // stepKey: seeShippingAddressStreetVerifyOrderAddressInformation
		$I->see("Austin", ".order-shipping-address address"); // stepKey: seeShippingAddressCityVerifyOrderAddressInformation
		$I->see("United States", ".order-shipping-address address"); // stepKey: seeAddressCountryVerifyOrderAddressInformation
		$I->see("78758", ".order-shipping-address address"); // stepKey: seeShippingAddressPostcodeVerifyOrderAddressInformation
		$I->comment("Exiting Action Group [verifyOrderAddressInformation] AssertOrderAddressInformationActionGroup");
		$I->see("Check / Money order", "//div[@class='order-payment-method-title']"); // stepKey: seePaymentMethod
		$I->comment("Entering Action Group [assertShippingOrderInformation] AdminAssertOrderShippingMethodActionGroup");
		$I->see("Flat Rate - Fixed", ".order-shipping-method .admin__page-section-item-content"); // stepKey: seeShippingMethodAssertShippingOrderInformation
		$I->see("$10.00", ".order-shipping-method .admin__page-section-item-content .price"); // stepKey: seeShippingMethodPriceAssertShippingOrderInformation
		$I->comment("Exiting Action Group [assertShippingOrderInformation] AdminAssertOrderShippingMethodActionGroup");
		$I->comment("Entering Action Group [seeFirstProductInItemsOrdered] SeeProductInItemsOrderedActionGroup");
		$I->see($I->retrieveEntityField('createFirstSimpleProduct', 'sku', 'test'), ".edit-order-table .col-product .product-sku-block"); // stepKey: seeSkuInItemsOrderedSeeFirstProductInItemsOrdered
		$I->comment("Exiting Action Group [seeFirstProductInItemsOrdered] SeeProductInItemsOrderedActionGroup");
		$I->comment("Entering Action Group [seeSecondProductInItemsOrdered] SeeProductInItemsOrderedActionGroup");
		$I->see($I->retrieveEntityField('createSecondSimpleProduct', 'sku', 'test'), ".edit-order-table .col-product .product-sku-block"); // stepKey: seeSkuInItemsOrderedSeeSecondProductInItemsOrdered
		$I->comment("Exiting Action Group [seeSecondProductInItemsOrdered] SeeProductInItemsOrderedActionGroup");
	}
}
