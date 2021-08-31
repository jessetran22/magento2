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
 * @Title("MC-35848: Create Credit Memo with zero total.")
 * @Description("Assert order status after create CreditMemo with zero total.<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCreateCreditMemoWithZeroPriceCheckOrderStatusTest.xml<br>")
 * @group sales
 * @TestCaseId("MC-35848")
 */
class AdminCreateCreditMemoWithZeroPriceCheckOrderStatusTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "SimpleProduct_zero", ["createCategory"], []); // stepKey: createProduct
		$I->createEntity("enableFreeShipping", "hook", "FreeShippinMethodConfig", [], []); // stepKey: enableFreeShipping
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->createEntity("disableFreeShipping", "hook", "FreeShippingMethodDisableConfig", [], []); // stepKey: disableFreeShipping
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
	 * @Stories({"Github issue: #22762 Credit Memo with Zero Total: Order Status 'Complete' and not 'Closed'"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCreditMemoWithZeroPriceCheckOrderStatusTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToNewOrderPage] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadNavigateToNewOrderPage
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleNavigateToNewOrderPage
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderNavigateToNewOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGridLoadNavigateToNewOrderPage
		$I->comment("Clear grid filters");
		$I->conditionalClick("#sales_order_create_customer_grid [data-action='grid-filter-reset']", "#sales_order_create_customer_grid [data-action='grid-filter-reset']", true); // stepKey: clearExistingCustomerFiltersNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: clearExistingCustomerFiltersNavigateToNewOrderPageWaitForPageLoad
		$I->fillField("#sales_order_create_customer_grid_filter_email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailNavigateToNewOrderPage
		$I->click(".action-secondary[title='Search']"); // stepKey: applyFilterNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForFilteredCustomerGridLoadNavigateToNewOrderPage
		$I->click("tr:nth-of-type(1)[data-role='row']"); // stepKey: clickOnCustomerNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadNavigateToNewOrderPage
		$I->comment("Select store view if appears");
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectNavigateToNewOrderPage
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleNavigateToNewOrderPage
		$I->comment("Exiting Action Group [navigateToNewOrderPage] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->comment("Entering Action Group [addSecondProduct] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddSecondProductWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddSecondProduct
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickSearchAddSecondProductWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddSecondProduct
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddSecondProduct
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "1"); // stepKey: fillProductQtyAddSecondProduct
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddSecondProduct
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddSecondProductWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddSecondProductWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddSecondProduct
		$I->comment("Exiting Action Group [addSecondProduct] AddSimpleProductToOrderActionGroup");
		$I->comment("Entering Action Group [fillCustomerInfo] FillOrderCustomerInformationActionGroup");
		$I->fillField("#order-billing_address_firstname", $I->retrieveEntityField('createCustomer', 'firstname', 'test')); // stepKey: fillFirstNameFillCustomerInfo
		$I->waitForPageLoad(30); // stepKey: fillFirstNameFillCustomerInfoWaitForPageLoad
		$I->fillField("#order-billing_address_lastname", $I->retrieveEntityField('createCustomer', 'lastname', 'test')); // stepKey: fillLastNameFillCustomerInfo
		$I->waitForPageLoad(30); // stepKey: fillLastNameFillCustomerInfoWaitForPageLoad
		$I->fillField("#order-billing_address_street0", "7700 West Parmer Lane"); // stepKey: fillStreetLine1FillCustomerInfo
		$I->waitForPageLoad(30); // stepKey: fillStreetLine1FillCustomerInfoWaitForPageLoad
		$I->fillField("#order-billing_address_city", "Austin"); // stepKey: fillCityFillCustomerInfo
		$I->waitForPageLoad(30); // stepKey: fillCityFillCustomerInfoWaitForPageLoad
		$I->selectOption("#order-billing_address_country_id", "US"); // stepKey: fillCountryFillCustomerInfo
		$I->waitForPageLoad(30); // stepKey: fillCountryFillCustomerInfoWaitForPageLoad
		$I->selectOption("#order-billing_address_region_id", "Texas"); // stepKey: fillStateFillCustomerInfo
		$I->waitForPageLoad(30); // stepKey: fillStateFillCustomerInfoWaitForPageLoad
		$I->fillField("#order-billing_address_postcode", "78729"); // stepKey: fillPostalCodeFillCustomerInfo
		$I->waitForPageLoad(30); // stepKey: fillPostalCodeFillCustomerInfoWaitForPageLoad
		$I->fillField("#order-billing_address_telephone", "512-345-6789"); // stepKey: fillPhoneFillCustomerInfo
		$I->waitForPageLoad(30); // stepKey: fillPhoneFillCustomerInfoWaitForPageLoad
		$I->comment("Exiting Action Group [fillCustomerInfo] FillOrderCustomerInformationActionGroup");
		$I->comment("Entering Action Group [selectFlatRate] OrderSelectFreeShippingActionGroup");
		$I->click("#order-methods span.title"); // stepKey: unfocusSelectFlatRate
		$I->waitForPageLoad(30); // stepKey: waitForJavascriptToFinishSelectFlatRate
		$I->click("#order-shipping_method a.action-default"); // stepKey: clickShippingMethodsSelectFlatRate
		$I->waitForPageLoad(30); // stepKey: clickShippingMethodsSelectFlatRateWaitForPageLoad
		$I->waitForElementVisible("#s_method_freeshipping_freeshipping", 30); // stepKey: waitForShippingOptionsSelectFlatRate
		$I->waitForPageLoad(30); // stepKey: waitForShippingOptionsSelectFlatRateWaitForPageLoad
		$I->selectOption("#s_method_freeshipping_freeshipping", "freeshipping_freeshipping"); // stepKey: checkFreeShippingSelectFlatRate
		$I->waitForPageLoad(30); // stepKey: checkFreeShippingSelectFlatRateWaitForPageLoad
		$I->comment("Exiting Action Group [selectFlatRate] OrderSelectFreeShippingActionGroup");
		$I->comment("Entering Action Group [submitOrder] AdminSubmitOrderActionGroup");
		$I->scrollTo("#submit_order_top_button"); // stepKey: scrollToSubmitButtonSubmitOrder
		$I->waitForPageLoad(60); // stepKey: scrollToSubmitButtonSubmitOrderWaitForPageLoad
		$I->click("#submit_order_top_button"); // stepKey: submitOrderSubmitOrder
		$I->waitForPageLoad(60); // stepKey: submitOrderSubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSubmitOrder
		$I->see("You created the order."); // stepKey: seeSuccessMessageForOrderSubmitOrder
		$I->comment("Exiting Action Group [submitOrder] AdminSubmitOrderActionGroup");
		$I->comment("Entering Action Group [createCreditMemo] AdminCreateInvoiceAndCreditMemoActionGroup");
		$I->click("#order_invoice"); // stepKey: clickInvoiceCreateCreditMemo
		$I->waitForPageLoad(30); // stepKey: clickInvoiceCreateCreditMemoWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForInvoicePageCreateCreditMemo
		$I->click(".action-default.scalable.save.submit-button.primary"); // stepKey: submitInvoiceCreateCreditMemo
		$I->waitForPageLoad(60); // stepKey: submitInvoiceCreateCreditMemoWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadPageCreateCreditMemo
		$I->see("The invoice has been created."); // stepKey: seeMessageCreateCreditMemo
		$I->click("#order_creditmemo"); // stepKey: pushButtonCreditMemoCreateCreditMemo
		$I->waitForPageLoad(30); // stepKey: pushButtonCreditMemoCreateCreditMemoWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadingCreditMemoPageCreateCreditMemo
		$I->scrollTo(".order-totals-actions button[data-ui-id='order-items-submit-button']"); // stepKey: scrollToBottomCreateCreditMemo
		$I->waitForPageLoad(60); // stepKey: scrollToBottomCreateCreditMemoWaitForPageLoad
		$I->click(".order-totals-actions button[data-ui-id='order-items-submit-button']"); // stepKey: clickSubmitRefundCreateCreditMemo
		$I->waitForPageLoad(60); // stepKey: clickSubmitRefundCreateCreditMemoWaitForPageLoad
		$I->waitForPageLoad(60); // stepKey: waitForMainOrderPageLoadCreateCreditMemo
		$I->see("You created the credit memo."); // stepKey: seeCreditMemoMessageCreateCreditMemo
		$I->comment("Exiting Action Group [createCreditMemo] AdminCreateInvoiceAndCreditMemoActionGroup");
		$I->comment("Entering Action Group [seeOrderClose] AdminOrderViewCheckStatusActionGroup");
		$I->see("Closed", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderStatusSeeOrderClose
		$I->comment("Exiting Action Group [seeOrderClose] AdminOrderViewCheckStatusActionGroup");
	}
}
