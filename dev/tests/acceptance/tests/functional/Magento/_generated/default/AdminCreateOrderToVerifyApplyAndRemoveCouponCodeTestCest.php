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
 * @Title("MC-38919: Create Order to verify apply and remove coupon code test")
 * @Description("Create Order to verify apply and remove coupon code test<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCreateOrderToVerifyApplyAndRemoveCouponCodeTest.xml<br>")
 * @TestCaseId("MC-38919")
 * @group sales
 */
class AdminCreateOrderToVerifyApplyAndRemoveCouponCodeTestCest
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
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$createSimpleProductFields['price'] = "10";
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], $createSimpleProductFields); // stepKey: createSimpleProduct
		$I->createEntity("createCartPriceRule", "hook", "SalesRuleSpecificCouponWithFixedDiscount", [], []); // stepKey: createCartPriceRule
		$I->createEntity("createCouponForCartPriceRule", "hook", "SimpleSalesRuleCoupon", ["createCartPriceRule"], []); // stepKey: createCouponForCartPriceRule
		$enableBankTransferPayment = $I->magentoCLI("config:set payment/banktransfer/active 1", 60); // stepKey: enableBankTransferPayment
		$I->comment($enableBankTransferPayment);
		$enableFlatRate = $I->magentoCLI("config:set carriers/flatrate/active 1", 60); // stepKey: enableFlatRate
		$I->comment($enableFlatRate);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$disableBankTransferPayment = $I->magentoCLI("config:set payment/banktransfer/active 0", 60); // stepKey: disableBankTransferPayment
		$I->comment($disableBankTransferPayment);
		$I->deleteEntity("createCartPriceRule", "hook"); // stepKey: deleteCartPriceRule
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
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
	 * @Stories({"Create Order with offline payment methods"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateOrderToVerifyApplyAndRemoveCouponCodeTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToCreateOrderPage] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageGoToCreateOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadGoToCreateOrderPage
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleGoToCreateOrderPage
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderGoToCreateOrderPage
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderGoToCreateOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGridLoadGoToCreateOrderPage
		$I->comment("Clear grid filters");
		$I->conditionalClick("#sales_order_create_customer_grid [data-action='grid-filter-reset']", "#sales_order_create_customer_grid [data-action='grid-filter-reset']", true); // stepKey: clearExistingCustomerFiltersGoToCreateOrderPage
		$I->waitForPageLoad(30); // stepKey: clearExistingCustomerFiltersGoToCreateOrderPageWaitForPageLoad
		$I->fillField("#sales_order_create_customer_grid_filter_email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailGoToCreateOrderPage
		$I->click(".action-secondary[title='Search']"); // stepKey: applyFilterGoToCreateOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForFilteredCustomerGridLoadGoToCreateOrderPage
		$I->click("tr:nth-of-type(1)[data-role='row']"); // stepKey: clickOnCustomerGoToCreateOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadGoToCreateOrderPage
		$I->comment("Select store view if appears");
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsGoToCreateOrderPage
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsGoToCreateOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectGoToCreateOrderPage
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleGoToCreateOrderPage
		$I->comment("Exiting Action Group [goToCreateOrderPage] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->comment("Entering Action Group [addProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchAddProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddProductToOrder
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "1"); // stepKey: fillProductQtyAddProductToOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddProductToOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddProductToOrder
		$I->comment("Exiting Action Group [addProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->comment("Entering Action Group [applyCoupon] AdminApplyCouponToOrderActionGroup");
		$I->fillField("#order-coupons input", $I->retrieveEntityField('createCouponForCartPriceRule', 'code', 'test')); // stepKey: fillCouponCodeApplyCoupon
		$I->waitForPageLoad(30); // stepKey: fillCouponCodeApplyCouponWaitForPageLoad
		$I->click("#order-coupons button"); // stepKey: applyCouponApplyCoupon
		$I->waitForPageLoad(30); // stepKey: waitForApplyingCouponApplyCoupon
		$I->see("The coupon code has been accepted.", "div.message-success"); // stepKey: seeSuccessMessageApplyCoupon
		$I->comment("Exiting Action Group [applyCoupon] AdminApplyCouponToOrderActionGroup");
		$I->comment("Entering Action Group [removeCoupon] AdminRemoveCouponFromOrderActionGroup");
		$I->click(".added-coupon-code .action-remove"); // stepKey: removeCouponRemoveCoupon
		$I->waitForPageLoad(30); // stepKey: waitForRemovingCouponRemoveCoupon
		$I->dontSee("The coupon code has been accepted.", "div.message-success"); // stepKey: dontSeePreviousMessageRemoveCoupon
		$I->see("The coupon code has been removed.", "div.message-success"); // stepKey: seeSuccessMessageRemoveCoupon
		$I->comment("Exiting Action Group [removeCoupon] AdminRemoveCouponFromOrderActionGroup");
		$I->comment("Entering Action Group [selectFlatRateShippingMethod] AdminSelectFlatRateShippingMethodActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoadSelectFlatRateShippingMethod
		$I->click("//span[text()='Get shipping methods and rates']"); // stepKey: openShippingMethodSelectFlatRateShippingMethod
		$I->waitForPageLoad(60); // stepKey: openShippingMethodSelectFlatRateShippingMethodWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethodsSelectFlatRateShippingMethod
		$I->click("//label[contains(text(), 'Fixed')]"); // stepKey: chooseShippingMethodSelectFlatRateShippingMethod
		$I->waitForPageLoad(60); // stepKey: chooseShippingMethodSelectFlatRateShippingMethodWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSelectFlatRateShippingMethod
		$I->comment("Exiting Action Group [selectFlatRateShippingMethod] AdminSelectFlatRateShippingMethodActionGroup");
		$I->waitForElementVisible("#order-billing_method", 30); // stepKey: waitForPaymentOptions
		$I->conditionalClick("#p_method_banktransfer", "#p_method_banktransfer", true); // stepKey: checkBankTransferOption
		$I->waitForPageLoad(30); // stepKey: checkBankTransferOptionWaitForPageLoad
		$I->comment("Entering Action Group [submitOrder] AdminSubmitOrderActionGroup");
		$I->scrollTo("#submit_order_top_button"); // stepKey: scrollToSubmitButtonSubmitOrder
		$I->waitForPageLoad(60); // stepKey: scrollToSubmitButtonSubmitOrderWaitForPageLoad
		$I->click("#submit_order_top_button"); // stepKey: submitOrderSubmitOrder
		$I->waitForPageLoad(60); // stepKey: submitOrderSubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSubmitOrder
		$I->see("You created the order."); // stepKey: seeSuccessMessageForOrderSubmitOrder
		$I->comment("Exiting Action Group [submitOrder] AdminSubmitOrderActionGroup");
		$getOrderId = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: getOrderId
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: goToOrdersPage
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageLoad
		$I->comment("Entering Action Group [filterOrdersGridById] FilterOrderGridByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrdersGridById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrdersGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrdersGridById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrdersGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrdersGridById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$getOrderId"); // stepKey: fillOrderIdFilterFilterOrdersGridById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrdersGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrdersGridById
		$I->comment("Exiting Action Group [filterOrdersGridById] FilterOrderGridByIdActionGroup");
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: clickCreatedOrderInGrid
		$I->waitForPageLoad(60); // stepKey: clickCreatedOrderInGridWaitForPageLoad
	}
}
