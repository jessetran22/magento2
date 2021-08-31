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
 * @Title("MC-25752: Checking Credit memo Totals")
 * @Description("Checking Credit memo Totals<h3>Test files</h3>app/code/Magento/Tax/Test/Mftf/Test/AdminCheckCreditMemoTotalsTest.xml<br>")
 * @TestCaseId("MC-25752")
 * @group tax
 * @group sales
 */
class AdminCheckCreditMemoTotalsTestCest
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
		$I->comment("Create productTaxClass");
		$I->createEntity("createProductTaxClass", "hook", "productTaxClass", [], []); // stepKey: createProductTaxClass
		$I->comment("Set configs");
		$setDefaultProductTaxClass = $I->magentoCLI("config:set tax/classes/default_product_tax_class " . $I->retrieveEntityField('createProductTaxClass', 'return', 'hook'), 60); // stepKey: setDefaultProductTaxClass
		$I->comment($setDefaultProductTaxClass);
		$I->comment("Create category and product");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$createSimpleProductFields['productTaxClass'] = $I->retrieveEntityField('createProductTaxClass', 'taxClass[class_name]', 'hook');
		$I->createEntity("createSimpleProduct", "hook", "_defaultProduct", ["createCategory"], $createSimpleProductFields); // stepKey: createSimpleProduct
		$I->comment("Create customer");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_NY", [], []); // stepKey: createCustomer
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create tax rule");
		$I->comment("Entering Action Group [createTaxRuleCustomProductTaxClass] AdminCreateTaxRuleCustomProductTaxClassActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule/new/"); // stepKey: goNewTaxRulePageCreateTaxRuleCustomProductTaxClass
		$I->waitForPageLoad(30); // stepKey: waitForNewTaxRulePageLoadedCreateTaxRuleCustomProductTaxClass
		$I->fillField("#anchor-content #code", "TaxIdentifier" . msq("defaultTaxRule")); // stepKey: fillRuleNameCreateTaxRuleCustomProductTaxClass
		$I->click("//span[text()='US-NY-*-Rate 1']"); // stepKey: selectTaxRateCreateTaxRuleCustomProductTaxClass
		$I->click("#details-summarybase_fieldset"); // stepKey: clickAdditionalSettingsCreateTaxRuleCustomProductTaxClass
		$I->waitForPageLoad(30); // stepKey: clickAdditionalSettingsCreateTaxRuleCustomProductTaxClassWaitForPageLoad
		$I->click("//div[contains(@class, 'field-tax_product_class')]//*[contains(@class, 'mselect-list-item') and contains(.,'Taxable Goods')]"); // stepKey: unSelectTaxClassCreateTaxRuleCustomProductTaxClass
		$I->click("//div[contains(@class, 'field-tax_product_class')]//*[contains(@class, 'mselect-list-item') and contains(.,'" . $I->retrieveEntityField('createProductTaxClass', 'taxClass[class_name]', 'hook') . "')]"); // stepKey: selectProductTaxClassCreateTaxRuleCustomProductTaxClass
		$I->click("#save"); // stepKey: clickSaveCreateTaxRuleCustomProductTaxClass
		$I->waitForPageLoad(30); // stepKey: clickSaveCreateTaxRuleCustomProductTaxClassWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageCreateTaxRuleCustomProductTaxClass
		$I->see("You saved the tax rule.", "#messages div.message-success"); // stepKey: verifyRuleSavedCreateTaxRuleCustomProductTaxClass
		$I->comment("Exiting Action Group [createTaxRuleCustomProductTaxClass] AdminCreateTaxRuleCustomProductTaxClassActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Set configs");
		$setDefaultProductTaxClass = $I->magentoCLI("config:set tax/classes/default_product_tax_class 2", 60); // stepKey: setDefaultProductTaxClass
		$I->comment($setDefaultProductTaxClass);
		$I->comment("Delete category and product");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Delete customer");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Reset admin order filter");
		$I->comment("Entering Action Group [clearOrderFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: goToGridOrdersPageClearOrderFilters
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClearOrderFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header .admin__data-grid-filters-current._show", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearOrderFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitAfterClearFiltersClearOrderFilters
		$I->comment("Exiting Action Group [clearOrderFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->comment("Go to the tax rule page and delete the row we created");
		$I->comment("Entering Action Group [goToTaxRulesPage] AdminTaxRuleGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule"); // stepKey: goToTaxRuleGridPageGoToTaxRulesPage
		$I->waitForPageLoad(30); // stepKey: waitForTaxRulePageGoToTaxRulesPage
		$I->comment("Exiting Action Group [goToTaxRulesPage] AdminTaxRuleGridOpenPageActionGroup");
		$I->comment("Entering Action Group [deleteRule] deleteEntitySecondaryGrid");
		$I->comment("search for the name");
		$I->click("[title='Reset Filter']"); // stepKey: resetFiltersDeleteRule
		$I->fillField(".col-code .admin__control-text", "TaxIdentifier" . msq("defaultTaxRule")); // stepKey: fillIdentifierDeleteRule
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: searchForNameDeleteRule
		$I->click("tr[data-role='row']"); // stepKey: clickResultDeleteRule
		$I->waitForPageLoad(30); // stepKey: waitForTaxRateLoadDeleteRule
		$I->comment("delete the rule");
		$I->click("#delete"); // stepKey: clickDeleteDeleteRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteRuleWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOkDeleteRule
		$I->waitForPageLoad(60); // stepKey: clickOkDeleteRuleWaitForPageLoad
		$I->see("deleted", ".message-success"); // stepKey: seeSuccessDeleteRule
		$I->comment("Exiting Action Group [deleteRule] deleteEntitySecondaryGrid");
		$I->comment("Entering Action Group [clearTaxRuleFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearTaxRuleFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearTaxRuleFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearTaxRuleFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Delete Tax Class");
		$I->deleteEntity("createProductTaxClass", "hook"); // stepKey: deleteProductTaxClass
		$I->comment("Logout");
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
	 * @Features({"Tax"})
	 * @Stories({"Credit memo entity"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckCreditMemoTotalsTest(AcceptanceTester $I)
	{
		$I->comment("Create new order");
		$I->comment("Entering Action Group [createNewOrder] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadCreateNewOrder
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleCreateNewOrder
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderCreateNewOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGridLoadCreateNewOrder
		$I->comment("Clear grid filters");
		$I->conditionalClick("#sales_order_create_customer_grid [data-action='grid-filter-reset']", "#sales_order_create_customer_grid [data-action='grid-filter-reset']", true); // stepKey: clearExistingCustomerFiltersCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: clearExistingCustomerFiltersCreateNewOrderWaitForPageLoad
		$I->fillField("#sales_order_create_customer_grid_filter_email", msq("Simple_US_Customer_NY") . "John.Doe@example.com"); // stepKey: filterEmailCreateNewOrder
		$I->click(".action-secondary[title='Search']"); // stepKey: applyFilterCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: waitForFilteredCustomerGridLoadCreateNewOrder
		$I->click("tr:nth-of-type(1)[data-role='row']"); // stepKey: clickOnCustomerCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadCreateNewOrder
		$I->comment("Select store view if appears");
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsCreateNewOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectCreateNewOrder
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleCreateNewOrder
		$I->comment("Exiting Action Group [createNewOrder] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->comment("Add product to order");
		$I->comment("Entering Action Group [addSimpleProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddSimpleProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddSimpleProductToOrder
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
		$I->comment("Set shipping method");
		$I->comment("Entering Action Group [orderSelectFlatRateShipping] OrderSelectFlatRateShippingActionGroup");
		$I->click("#order-methods span.title"); // stepKey: unfocusOrderSelectFlatRateShipping
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForJavascriptToFinishOrderSelectFlatRateShipping
		$I->click("#order-shipping_method a.action-default"); // stepKey: clickShippingMethodsOrderSelectFlatRateShipping
		$I->waitForPageLoad(30); // stepKey: clickShippingMethodsOrderSelectFlatRateShippingWaitForPageLoad
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingOptionsOrderSelectFlatRateShipping
		$I->waitForPageLoad(30); // stepKey: waitForShippingOptionsOrderSelectFlatRateShippingWaitForPageLoad
		$I->selectOption("#s_method_flatrate_flatrate", "flatrate_flatrate"); // stepKey: checkFlatRateOrderSelectFlatRateShipping
		$I->waitForPageLoad(30); // stepKey: checkFlatRateOrderSelectFlatRateShippingWaitForPageLoad
		$I->comment("Exiting Action Group [orderSelectFlatRateShipping] OrderSelectFlatRateShippingActionGroup");
		$I->comment("Submit order");
		$I->comment("Entering Action Group [submitOrder] AdminSubmitOrderActionGroup");
		$I->scrollTo("#submit_order_top_button"); // stepKey: scrollToSubmitButtonSubmitOrder
		$I->waitForPageLoad(60); // stepKey: scrollToSubmitButtonSubmitOrderWaitForPageLoad
		$I->click("#submit_order_top_button"); // stepKey: submitOrderSubmitOrder
		$I->waitForPageLoad(60); // stepKey: submitOrderSubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSubmitOrder
		$I->see("You created the order."); // stepKey: seeSuccessMessageForOrderSubmitOrder
		$I->comment("Exiting Action Group [submitOrder] AdminSubmitOrderActionGroup");
		$I->comment("Create order invoice");
		$I->comment("Entering Action Group [startCreateInvoice] StartCreateInvoiceFromOrderPageActionGroup");
		$I->click("#order_invoice"); // stepKey: clickInvoiceActionStartCreateInvoice
		$I->waitForPageLoad(30); // stepKey: clickInvoiceActionStartCreateInvoiceWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_invoice/new/order_id/"); // stepKey: seeNewInvoiceUrlStartCreateInvoice
		$I->see("New Invoice", ".page-header h1.page-title"); // stepKey: seeNewInvoicePageTitleStartCreateInvoice
		$I->comment("Exiting Action Group [startCreateInvoice] StartCreateInvoiceFromOrderPageActionGroup");
		$I->comment("Entering Action Group [submitInvoice] SubmitInvoiceActionGroup");
		$I->click(".action-default.scalable.save.submit-button.primary"); // stepKey: clickSubmitInvoiceSubmitInvoice
		$I->waitForPageLoad(60); // stepKey: clickSubmitInvoiceSubmitInvoiceWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageAppearsSubmitInvoice
		$I->see("The invoice has been created.", "#messages div.message-success"); // stepKey: seeInvoiceCreateSuccessSubmitInvoice
		$grabOrderIdSubmitInvoice = $I->grabFromCurrentUrl("~/order_id/(\d+)/~"); // stepKey: grabOrderIdSubmitInvoice
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/"); // stepKey: seeViewOrderPageInvoiceSubmitInvoice
		$I->comment("Exiting Action Group [submitInvoice] SubmitInvoiceActionGroup");
		$I->comment("Create Credit Memo");
		$I->comment("Entering Action Group [startCreatingCreditMemo] AdminStartToCreateCreditMemoFromOrderPageActionGroup");
		$I->click("#order_creditmemo"); // stepKey: clickCreditMemoStartCreatingCreditMemo
		$I->waitForPageLoad(30); // stepKey: clickCreditMemoStartCreatingCreditMemoWaitForPageLoad
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForPageTitleStartCreatingCreditMemo
		$I->see("New Memo", ".page-header h1.page-title"); // stepKey: seeNewMemoPageTitleStartCreatingCreditMemo
		$I->comment("Exiting Action Group [startCreatingCreditMemo] AdminStartToCreateCreditMemoFromOrderPageActionGroup");
		$I->fillField(".order-subtotal-table tbody input[name='creditmemo[shipping_amount]']", "0"); // stepKey: setRefundShipping
		$I->comment("Entering Action Group [updateTotals] UpdateCreditMemoTotalsActionGroup");
		$I->waitForElementVisible(".update-totals-button", 30); // stepKey: waitUpdateTotalsButtonEnabledUpdateTotals
		$I->waitForPageLoad(30); // stepKey: waitUpdateTotalsButtonEnabledUpdateTotalsWaitForPageLoad
		$I->click(".update-totals-button"); // stepKey: clickUpdateTotalsUpdateTotals
		$I->waitForPageLoad(30); // stepKey: clickUpdateTotalsUpdateTotalsWaitForPageLoad
		$I->comment("Exiting Action Group [updateTotals] UpdateCreditMemoTotalsActionGroup");
		$I->comment("Entering Action Group [submitCreditMemo] SubmitCreditMemoActionGroup");
		$grabOrderIdSubmitCreditMemo = $I->grabFromCurrentUrl("~/order_id/(\d+)/~"); // stepKey: grabOrderIdSubmitCreditMemo
		$I->waitForElementVisible(".order-totals-actions button[data-ui-id='order-items-submit-button']:not(.disabled)", 30); // stepKey: waitButtonEnabledSubmitCreditMemo
		$I->waitForPageLoad(60); // stepKey: waitButtonEnabledSubmitCreditMemoWaitForPageLoad
		$I->click(".order-totals-actions button[data-ui-id='order-items-submit-button']:not(.disabled)"); // stepKey: clickSubmitCreditMemoSubmitCreditMemo
		$I->waitForPageLoad(60); // stepKey: clickSubmitCreditMemoSubmitCreditMemoWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageAppearsSubmitCreditMemo
		$I->see("You created the credit memo.", "#messages div.message-success"); // stepKey: seeCreditMemoCreateSuccessSubmitCreditMemo
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/$grabOrderIdSubmitCreditMemo"); // stepKey: seeViewOrderPageCreditMemoSubmitCreditMemo
		$I->comment("Exiting Action Group [submitCreditMemo] SubmitCreditMemoActionGroup");
		$I->comment("Entering Action Group [openCreditMemoFromOrderPageActionGroup] AdminOpenCreditMemoFromOrderPageActionGroup");
		$I->conditionalClick("#sales_order_view_tabs_order_creditmemos", "#sales_order_view_tabs_order_creditmemos_content .data-grid tbody > tr:nth-of-type(1) a[href*='order_creditmemo/view']", false); // stepKey: openCreditMemosTabOpenCreditMemoFromOrderPageActionGroup
		$I->waitForElementVisible("div#sales_order_view_tabs_order_creditmemos_content a.action-menu-item", 30); // stepKey: waitForCreditMemosTabOpenedOpenCreditMemoFromOrderPageActionGroup
		$I->click("#sales_order_view_tabs_order_creditmemos_content .data-grid tbody > tr:nth-of-type(1) a[href*='order_creditmemo/view']"); // stepKey: viewMemoOpenCreditMemoFromOrderPageActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForCreditMemoOpenedOpenCreditMemoFromOrderPageActionGroup
		$I->comment("Exiting Action Group [openCreditMemoFromOrderPageActionGroup] AdminOpenCreditMemoFromOrderPageActionGroup");
		$I->comment("Entering Action Group [assertGrandTotal] AssertAdminCreditMemoGrandTotalActionGroup");
		$getGrandTotalAssertGrandTotal = $I->grabTextFrom(".order-subtotal-table tfoot tr.col-0>td span.price"); // stepKey: getGrandTotalAssertGrandTotal
		$I->assertEquals("$133.30", $getGrandTotalAssertGrandTotal); // stepKey: assertGrandTotalValueAssertGrandTotal
		$I->comment("Exiting Action Group [assertGrandTotal] AssertAdminCreditMemoGrandTotalActionGroup");
	}
}
