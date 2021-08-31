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
 * @Title("MAGETWO-92925: Admin order is not restricted by 'Minimum Order Amount' configuration.")
 * @Description("Admin should be able to create an order regardless of the minimum order amount.<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCreateOrderWithMinimumAmountEnabledTest.xml<br>")
 * @TestCaseId("MAGETWO-92925")
 * @group sales
 */
class AdminCreateOrderWithMinimumAmountEnabledTestCest
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
		$I->comment("Entering Action Group [enableAdminAccountSharing] EnableAdminAccountSharingActionGroup");
		$I->createEntity("setConfigEnableAdminAccountSharing", "hook", "EnableAdminAccountSharing", [], []); // stepKey: setConfigEnableAdminAccountSharing
		$I->comment("Exiting Action Group [enableAdminAccountSharing] EnableAdminAccountSharingActionGroup");
		$I->createEntity("enableMinimumOrderAmount", "hook", "EnabledMinimumOrderAmount500", [], []); // stepKey: enableMinimumOrderAmount
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [clearCacheBefore] ClearCacheActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/cache"); // stepKey: goToCacheManagementClearCacheBefore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClearCacheBefore
		$I->click("#flush_magento"); // stepKey: clickFlushMagentoCacheClearCacheBefore
		$I->waitForPageLoad(30); // stepKey: waitForCacheFlushClearCacheBefore
		$I->comment("Exiting Action Group [clearCacheBefore] ClearCacheActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->createEntity("disableMinimumOrderAmount", "hook", "DisabledMinimumOrderAmount", [], []); // stepKey: disableMinimumOrderAmount
		$I->comment("Entering Action Group [clearCacheAfter] ClearCacheActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/cache"); // stepKey: goToCacheManagementClearCacheAfter
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClearCacheAfter
		$I->click("#flush_magento"); // stepKey: clickFlushMagentoCacheClearCacheAfter
		$I->waitForPageLoad(30); // stepKey: waitForCacheFlushClearCacheAfter
		$I->comment("Exiting Action Group [clearCacheAfter] ClearCacheActionGroup");
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
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
	 * @Stories({"Admin create order"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateOrderWithMinimumAmountEnabledTest(AcceptanceTester $I)
	{
		$I->comment("Admin creates order");
		$I->comment("Admin creates order");
		$I->comment("Entering Action Group [navigateToNewOrderPage] NavigateToNewOrderPageNewCustomerSingleStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadNavigateToNewOrderPage
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleNavigateToNewOrderPage
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderNavigateToNewOrderPageWaitForPageLoad
		$I->click("#order-customer-selector .actions button.primary"); // stepKey: clickCreateCustomerNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: clickCreateCustomerNavigateToNewOrderPageWaitForPageLoad
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderPageWaitForPageLoad
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleNavigateToNewOrderPage
		$I->comment("Exiting Action Group [navigateToNewOrderPage] NavigateToNewOrderPageNewCustomerSingleStoreActionGroup");
		$I->conditionalClick("//*[contains(@class,'tree-store-scope')]//label[contains(text(),'Default Store View')]", "#order-store-selector", true); // stepKey: selectFirstStoreViewIfAppears
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskDisappearedAfterStoreSelected
		$I->comment("Entering Action Group [addSimpleProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddSimpleProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", "SimpleProduct" . msq("SimpleProduct")); // stepKey: fillSkuFilterAddSimpleProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchAddSimpleProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddSimpleProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddSimpleProductToOrder
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "1"); // stepKey: fillProductQtyAddSimpleProductToOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddSimpleProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddSimpleProductToOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddSimpleProductToOrder
		$I->comment("Exiting Action Group [addSimpleProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->comment("Fill customer group information");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [fillEmail] AdminFillAccountInformationOnCreateOrderPageActionGroup");
		$I->selectOption("#group_id", "General"); // stepKey: selectCustomerGroupFillEmail
		$I->fillField("#email", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: fillCustomerEmailFillEmail
		$I->comment("Exiting Action Group [fillEmail] AdminFillAccountInformationOnCreateOrderPageActionGroup");
		$I->comment("Fill customer address information");
		$I->comment("Entering Action Group [fillCustomerAddress] FillOrderCustomerInformationActionGroup");
		$I->fillField("#order-billing_address_firstname", "John"); // stepKey: fillFirstNameFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillFirstNameFillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_lastname", "Doe"); // stepKey: fillLastNameFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillLastNameFillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_street0", "7700 West Parmer Lane"); // stepKey: fillStreetLine1FillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillStreetLine1FillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_city", "Austin"); // stepKey: fillCityFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillCityFillCustomerAddressWaitForPageLoad
		$I->selectOption("#order-billing_address_country_id", "US"); // stepKey: fillCountryFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillCountryFillCustomerAddressWaitForPageLoad
		$I->selectOption("#order-billing_address_region_id", "Texas"); // stepKey: fillStateFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillStateFillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_postcode", "78729"); // stepKey: fillPostalCodeFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillPostalCodeFillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_telephone", "512-345-6789"); // stepKey: fillPhoneFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillPhoneFillCustomerAddressWaitForPageLoad
		$I->comment("Exiting Action Group [fillCustomerAddress] FillOrderCustomerInformationActionGroup");
		$I->comment("Entering Action Group [selectFlatRateShipping] OrderSelectFlatRateShippingActionGroup");
		$I->click("#order-methods span.title"); // stepKey: unfocusSelectFlatRateShipping
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForJavascriptToFinishSelectFlatRateShipping
		$I->click("#order-shipping_method a.action-default"); // stepKey: clickShippingMethodsSelectFlatRateShipping
		$I->waitForPageLoad(30); // stepKey: clickShippingMethodsSelectFlatRateShippingWaitForPageLoad
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingOptionsSelectFlatRateShipping
		$I->waitForPageLoad(30); // stepKey: waitForShippingOptionsSelectFlatRateShippingWaitForPageLoad
		$I->selectOption("#s_method_flatrate_flatrate", "flatrate_flatrate"); // stepKey: checkFlatRateSelectFlatRateShipping
		$I->waitForPageLoad(30); // stepKey: checkFlatRateSelectFlatRateShippingWaitForPageLoad
		$I->comment("Exiting Action Group [selectFlatRateShipping] OrderSelectFlatRateShippingActionGroup");
		$I->comment("Checkout select Check/Money Order payment");
		$I->comment("Entering Action Group [selectCheckMoneyPayment] SelectCheckMoneyPaymentMethodActionGroup");
		$I->waitForElementVisible("#order-billing_method", 30); // stepKey: waitForPaymentOptionsSelectCheckMoneyPayment
		$I->conditionalClick("#p_method_checkmo", "#p_method_checkmo", true); // stepKey: checkCheckMoneyOptionSelectCheckMoneyPayment
		$I->waitForPageLoad(30); // stepKey: checkCheckMoneyOptionSelectCheckMoneyPaymentWaitForPageLoad
		$I->comment("Exiting Action Group [selectCheckMoneyPayment] SelectCheckMoneyPaymentMethodActionGroup");
		$I->comment("Verify totals on Order page");
		$I->see("$123.00", "//tr[contains(@class,'row-totals')]/td[contains(text(), 'Subtotal')]/following-sibling::td/span[contains(@class, 'price')]"); // stepKey: seeOrderSubTotal
		$I->see("$5.00", "//tr[contains(@class,'row-totals')]/td[contains(text(), 'Shipping')]/following-sibling::td/span[contains(@class, 'price')]"); // stepKey: seeOrderShipping
		$I->see("$128.00", "//tr[contains(@class,'row-totals')]/td/strong[contains(text(), 'Grand Total')]/parent::td/following-sibling::td//span[contains(@class, 'price')]"); // stepKey: seeCorrectGrandTotal
		$I->comment("Entering Action Group [clickSubmitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->click("#submit_order_top_button"); // stepKey: clickSubmitOrderClickSubmitOrder
		$I->waitForPageLoad(30); // stepKey: clickSubmitOrderClickSubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoadClickSubmitOrder
		$I->comment("Exiting Action Group [clickSubmitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/"); // stepKey: seeViewOrderPage
		$I->see("You created the order.", "div.message-success"); // stepKey: seeSuccessMessage
		$I->see("Pending", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderPendingStatus
		$orderId = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: orderId
		$I->assertNotEmpty($orderId); // stepKey: assertOrderIdIsNotEmpty
		$I->comment("Entering Action Group [verifyOrderInformation] VerifyBasicOrderInformationActionGroup");
		$I->see("John", ".order-account-information table tr:first-of-type > td span"); // stepKey: seeCustomerNameVerifyOrderInformation
		$I->see(msq("Simple_US_Customer") . "John.Doe@example.com", ".order-account-information table tr:nth-of-type(2) > td a"); // stepKey: seeCustomerEmailVerifyOrderInformation
		$I->see("General", ".order-account-information table tr:nth-of-type(3) > td"); // stepKey: seeCustomerGroupVerifyOrderInformation
		$I->see("7700 West Parmer Lane", ".order-billing-address address"); // stepKey: seeBillingAddressStreetVerifyOrderInformation
		$I->see("Austin", ".order-billing-address address"); // stepKey: seeBillingAddressCityVerifyOrderInformation
		$I->see("US", ".order-billing-address address"); // stepKey: seeBillingAddressCountryVerifyOrderInformation
		$I->see("78729", ".order-billing-address address"); // stepKey: seeBillingAddressPostcodeVerifyOrderInformation
		$I->see("7700 West Parmer Lane", ".order-shipping-address address"); // stepKey: seeShippingAddressStreetVerifyOrderInformation
		$I->see("Austin", ".order-shipping-address address"); // stepKey: seeShippingAddressCityVerifyOrderInformation
		$I->see("US", ".order-shipping-address address"); // stepKey: seeShippingAddressCountryVerifyOrderInformation
		$I->see("78729", ".order-shipping-address address"); // stepKey: seeShippingAddressPostcodeVerifyOrderInformation
		$I->comment("Exiting Action Group [verifyOrderInformation] VerifyBasicOrderInformationActionGroup");
		$I->comment("Entering Action Group [seeSimpleProductInItemsOrdered] SeeProductInItemsOrderedActionGroup");
		$I->see("SimpleProduct" . msq("SimpleProduct"), ".edit-order-table .col-product .product-sku-block"); // stepKey: seeSkuInItemsOrderedSeeSimpleProductInItemsOrdered
		$I->comment("Exiting Action Group [seeSimpleProductInItemsOrdered] SeeProductInItemsOrderedActionGroup");
	}
}
