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
 * @Title("MC-25815: Checking Tax Report grid")
 * @Description("Tax Report Grid displays Tax amount in rows 'Total' and 'Subtotal' is a sum of all tax amounts<h3>Test files</h3>app/code/Magento/Tax/Test/Mftf/Test/AdminCheckingTaxReportGridTest.xml<br>")
 * @TestCaseId("MC-25815")
 * @group Tax
 */
class AdminCheckingTaxReportGridTestCest
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
		$I->comment("Create category and product");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createFirstProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createFirstProduct
		$I->createEntity("createSecondProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSecondProduct
		$I->comment("Create Tax Rule and Tax Rate");
		$I->createEntity("createTaxRule", "hook", "SimpleTaxRule", [], []); // stepKey: createTaxRule
		$I->createEntity("createSecondTaxRule", "hook", "SimpleTaxRule", [], []); // stepKey: createSecondTaxRule
		$I->createEntity("createTaxRate", "hook", "TaxRateTexas", [], []); // stepKey: createTaxRate
		$I->createEntity("createSecondTaxRate", "hook", "SecondTaxRateTexas", [], []); // stepKey: createSecondTaxRate
		$I->comment("Create product tax class");
		$I->createEntity("createProductTaxClass", "hook", "productTaxClass", [], []); // stepKey: createProductTaxClass
		$I->getEntity("productTaxClass", "hook", "productTaxClass", ["createProductTaxClass"], null); // stepKey: productTaxClass
		$I->createEntity("createSecondProductTaxClass", "hook", "productTaxClass", [], []); // stepKey: createSecondProductTaxClass
		$I->getEntity("productSecondTaxClass", "hook", "productTaxClass", ["createSecondProductTaxClass"], null); // stepKey: productSecondTaxClass
		$I->comment("Login to Admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Go to Tax Rule page, add Tax Rate, unassign Default Tax Rate");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule/edit/rule/" . $I->retrieveEntityField('createTaxRule', 'id', 'hook') . "/"); // stepKey: goToTaxRulePage
		$I->waitForPageLoad(30); // stepKey: waitForTaxRulePage
		$I->comment("Entering Action Group [assignTaxRate] AdminSelectTaxRateActionGroup");
		$I->fillField("input[data-role='advanced-select-text']", $I->retrieveEntityField('createTaxRate', 'code', 'hook')); // stepKey: searchTaxRateAssignTaxRate
		$I->waitForPageLoad(30); // stepKey: waitForAjaxLoadAssignTaxRate
		$I->waitForElementVisible("//*[@data-ui-id='tax-rate-form-fieldset-element-form-field-tax-rate']//span[.='" . $I->retrieveEntityField('createTaxRate', 'code', 'hook') . "']", 30); // stepKey: waitForVisibleTaxRateAssignTaxRate
		$I->click("//*[@data-ui-id='tax-rate-form-fieldset-element-form-field-tax-rate']//span[.='" . $I->retrieveEntityField('createTaxRate', 'code', 'hook') . "']"); // stepKey: clickTaxRateAssignTaxRate
		$I->comment("Exiting Action Group [assignTaxRate] AdminSelectTaxRateActionGroup");
		$I->comment("Assign Product Tax Class and Unassign Default Product Tax Class");
		$I->comment("Entering Action Group [assignProductTaxClass] AdminSelectProductTaxClassActionGroup");
		$I->conditionalClick("#details-summarybase_fieldset", "#detailsbase_fieldset[open]", false); // stepKey: openAdditionalSettingsAssignProductTaxClass
		$I->waitForElementVisible("//*[@id='tax_product_class']/..//span[.='" . $I->retrieveEntityField('productTaxClass', 'class_name', 'hook') . "']", 30); // stepKey: waitForVisibleTaxClassAssignProductTaxClass
		$I->conditionalClick("//*[@id='tax_product_class']/..//span[.='" . $I->retrieveEntityField('productTaxClass', 'class_name', 'hook') . "']", "//*[@id='tax_product_class']/..//span[.='" . $I->retrieveEntityField('productTaxClass', 'class_name', 'hook') . "' and preceding-sibling::input[contains(@class, 'mselect-checked')]]", false); // stepKey: assignProdTaxClassAssignProductTaxClass
		$I->comment("Exiting Action Group [assignProductTaxClass] AdminSelectProductTaxClassActionGroup");
		$I->comment("Entering Action Group [unSelectTaxRuleDefaultProductTax] AdminUnassignProductTaxClassActionGroup");
		$I->conditionalClick("#details-summarybase_fieldset", "#detailsbase_fieldset[open]", false); // stepKey: openAdditionalSettingsUnSelectTaxRuleDefaultProductTax
		$I->waitForElementVisible("//div[contains(@class, 'field-tax_product_class')]//span[text()='Add New Tax Class']", 30); // stepKey: waitForAddProductTaxClassButtonUnSelectTaxRuleDefaultProductTax
		$I->conditionalClick("//*[@id='tax_product_class']/..//span[.='Taxable Goods']", "//*[@id='tax_product_class']/..//span[.='Taxable Goods' and preceding-sibling::input[contains(@class, 'mselect-checked')]]", true); // stepKey: unSelectTaxClassUnSelectTaxRuleDefaultProductTax
		$I->comment("Exiting Action Group [unSelectTaxRuleDefaultProductTax] AdminUnassignProductTaxClassActionGroup");
		$I->comment("Save Tax Rule");
		$I->comment("Entering Action Group [saveTaxRule] ClickSaveButtonActionGroup");
		$I->click("#save"); // stepKey: clickSaveSaveTaxRule
		$I->waitForPageLoad(30); // stepKey: clickSaveSaveTaxRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitMessageSaveTaxRule
		$I->see("You saved the tax rule.", "#messages div.message-success"); // stepKey: verifyMessageSaveTaxRule
		$I->comment("Exiting Action Group [saveTaxRule] ClickSaveButtonActionGroup");
		$I->comment("Go to Tax Rule page to create second Tax Rule, add Tax Rate, unassign Default Tax Rate");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule/edit/rule/" . $I->retrieveEntityField('createSecondTaxRule', 'id', 'hook') . "/"); // stepKey: goToSecondTaxRulePage
		$I->waitForPageLoad(30); // stepKey: waitForSecondTaxRatePage
		$I->comment("Entering Action Group [assignSecondTaxRate] AdminSelectTaxRateActionGroup");
		$I->fillField("input[data-role='advanced-select-text']", $I->retrieveEntityField('createSecondTaxRate', 'code', 'hook')); // stepKey: searchTaxRateAssignSecondTaxRate
		$I->waitForPageLoad(30); // stepKey: waitForAjaxLoadAssignSecondTaxRate
		$I->waitForElementVisible("//*[@data-ui-id='tax-rate-form-fieldset-element-form-field-tax-rate']//span[.='" . $I->retrieveEntityField('createSecondTaxRate', 'code', 'hook') . "']", 30); // stepKey: waitForVisibleTaxRateAssignSecondTaxRate
		$I->click("//*[@data-ui-id='tax-rate-form-fieldset-element-form-field-tax-rate']//span[.='" . $I->retrieveEntityField('createSecondTaxRate', 'code', 'hook') . "']"); // stepKey: clickTaxRateAssignSecondTaxRate
		$I->comment("Exiting Action Group [assignSecondTaxRate] AdminSelectTaxRateActionGroup");
		$I->comment("Assign Product Tax Class and Unassign Default Product Tax Class");
		$I->comment("Entering Action Group [assignSecondProductTaxClass] AdminSelectProductTaxClassActionGroup");
		$I->conditionalClick("#details-summarybase_fieldset", "#detailsbase_fieldset[open]", false); // stepKey: openAdditionalSettingsAssignSecondProductTaxClass
		$I->waitForElementVisible("//*[@id='tax_product_class']/..//span[.='" . $I->retrieveEntityField('productSecondTaxClass', 'class_name', 'hook') . "']", 30); // stepKey: waitForVisibleTaxClassAssignSecondProductTaxClass
		$I->conditionalClick("//*[@id='tax_product_class']/..//span[.='" . $I->retrieveEntityField('productSecondTaxClass', 'class_name', 'hook') . "']", "//*[@id='tax_product_class']/..//span[.='" . $I->retrieveEntityField('productSecondTaxClass', 'class_name', 'hook') . "' and preceding-sibling::input[contains(@class, 'mselect-checked')]]", false); // stepKey: assignProdTaxClassAssignSecondProductTaxClass
		$I->comment("Exiting Action Group [assignSecondProductTaxClass] AdminSelectProductTaxClassActionGroup");
		$I->comment("Entering Action Group [unaSelectTaxRuleDefaultSecondProductTaxClass] AdminUnassignProductTaxClassActionGroup");
		$I->conditionalClick("#details-summarybase_fieldset", "#detailsbase_fieldset[open]", false); // stepKey: openAdditionalSettingsUnaSelectTaxRuleDefaultSecondProductTaxClass
		$I->waitForElementVisible("//div[contains(@class, 'field-tax_product_class')]//span[text()='Add New Tax Class']", 30); // stepKey: waitForAddProductTaxClassButtonUnaSelectTaxRuleDefaultSecondProductTaxClass
		$I->conditionalClick("//*[@id='tax_product_class']/..//span[.='Taxable Goods']", "//*[@id='tax_product_class']/..//span[.='Taxable Goods' and preceding-sibling::input[contains(@class, 'mselect-checked')]]", true); // stepKey: unSelectTaxClassUnaSelectTaxRuleDefaultSecondProductTaxClass
		$I->comment("Exiting Action Group [unaSelectTaxRuleDefaultSecondProductTaxClass] AdminUnassignProductTaxClassActionGroup");
		$I->comment("Save Tax Rule");
		$I->comment("Entering Action Group [saveSecondTaxRule] ClickSaveButtonActionGroup");
		$I->click("#save"); // stepKey: clickSaveSaveSecondTaxRule
		$I->waitForPageLoad(30); // stepKey: clickSaveSaveSecondTaxRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitMessageSaveSecondTaxRule
		$I->see("You saved the tax rule.", "#messages div.message-success"); // stepKey: verifyMessageSaveSecondTaxRule
		$I->comment("Exiting Action Group [saveSecondTaxRule] ClickSaveButtonActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete product and category");
		$I->deleteEntity("createFirstProduct", "hook"); // stepKey: deleteFirstProduct
		$I->deleteEntity("createSecondProduct", "hook"); // stepKey: deleteSecondProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Delete Tax Rule");
		$I->deleteEntity("createTaxRule", "hook"); // stepKey: deleteRule
		$I->deleteEntity("createSecondTaxRule", "hook"); // stepKey: deleteSecondRule
		$I->comment("Delete Tax Rate");
		$I->deleteEntity("createTaxRate", "hook"); // stepKey: deleteTaxRate
		$I->deleteEntity("createSecondTaxRate", "hook"); // stepKey: deleteSecondTaxRate
		$I->comment("Delete Product Tax Class");
		$I->deleteEntity("createProductTaxClass", "hook"); // stepKey: deleteProductTaxClass
		$I->deleteEntity("createSecondProductTaxClass", "hook"); // stepKey: deleteSecondProductTaxClass
		$I->comment("Clear filter Product");
		$I->comment("Entering Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductGridPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductGridPage
		$I->comment("Exiting Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [clearFilterProduct] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilterProduct
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilterProductWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilterProduct] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Delete Customer and clear filter");
		$I->comment("Entering Action Group [deleteCustomer] DeleteCustomerByEmailActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitForAdminCustomerPageLoadDeleteCustomer
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: clickFilterButtonDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickFilterButtonDeleteCustomerWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetDeleteCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersDeleteCustomer
		$I->fillField("input[name=email]", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: filterEmailDeleteCustomer
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: applyFilterDeleteCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadDeleteCustomer
		$I->click("//td[@class='data-grid-checkbox-cell']"); // stepKey: clickOnEditButton1DeleteCustomer
		$I->click("//div[@class='col-xs-2']/div[@class='action-select-wrap']/button[@class='action-select']"); // stepKey: clickActionsDropdownDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickActionsDropdownDeleteCustomerWaitForPageLoad
		$I->click("//*[contains(@class,'admin__data-grid-header-row row row-gutter')]//*[text()='Delete']"); // stepKey: clickDeleteDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteCustomerWaitForPageLoad
		$I->waitForElementVisible("//button[@data-role='action']//span[text()='OK']", 30); // stepKey: waitForOkToVisibleDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitForOkToVisibleDeleteCustomerWaitForPageLoad
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: clickOkConfirmationButtonDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickOkConfirmationButtonDeleteCustomerWaitForPageLoad
		$I->waitForElementVisible("//*[@class='message message-success success']", 30); // stepKey: waitForSuccessfullyDeletedMessageDeleteCustomer
		$I->comment("Exiting Action Group [deleteCustomer] DeleteCustomerByEmailActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleAssertSuccessMessage
		$I->see("A total of 1 record(s) were deleted.", "#messages div.message-success"); // stepKey: verifyMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [clearFilterCustomer] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilterCustomer
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilterCustomerWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilterCustomer] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Logout Admin");
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
	 * @Stories({"Tax Report Grid"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckingTaxReportGridTest(AcceptanceTester $I)
	{
		$I->comment("Open Created product. In Tax Class select new created Product Tax class.");
		$I->comment("Entering Action Group [openProductForEdit] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createFirstProduct', 'id', 'test')); // stepKey: goToProductOpenProductForEdit
		$I->comment("Exiting Action Group [openProductForEdit] AdminProductPageOpenByIdActionGroup");
		$I->selectOption("//*[@name='product[tax_class_id]']", $I->retrieveEntityField('productTaxClass', 'class_name', 'test')); // stepKey: selectTexClassForProduct
		$I->comment("Save the second product");
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$I->comment("Open Created Second Product. In Tax Class select new created Product Tax class.");
		$I->comment("Entering Action Group [openSecondProductForEdit] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createSecondProduct', 'id', 'test')); // stepKey: goToProductOpenSecondProductForEdit
		$I->comment("Exiting Action Group [openSecondProductForEdit] AdminProductPageOpenByIdActionGroup");
		$I->selectOption("//*[@name='product[tax_class_id]']", $I->retrieveEntityField('productSecondTaxClass', 'class_name', 'test')); // stepKey: selectTexClassForSecondProduct
		$I->comment("Save the second product");
		$I->comment("Entering Action Group [saveSecondProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveSecondProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveSecondProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveSecondProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveSecondProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveSecondProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveSecondProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveSecondProduct
		$I->comment("Exiting Action Group [saveSecondProduct] SaveProductFormActionGroup");
		$I->comment("Create an order with these 2 products in that zip code.");
		$I->comment("Entering Action Group [navigateToNewOrder] NavigateToNewOrderPageNewCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageNavigateToNewOrder
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadNavigateToNewOrder
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleNavigateToNewOrder
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderNavigateToNewOrder
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderNavigateToNewOrderWaitForPageLoad
		$I->click("#order-customer-selector .actions button.primary"); // stepKey: clickCreateCustomerNavigateToNewOrder
		$I->waitForPageLoad(30); // stepKey: clickCreateCustomerNavigateToNewOrderWaitForPageLoad
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsNavigateToNewOrder
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectNavigateToNewOrder
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleNavigateToNewOrder
		$I->comment("Exiting Action Group [navigateToNewOrder] NavigateToNewOrderPageNewCustomerActionGroup");
		$I->comment("Check if order can be submitted without the required fields including email address");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfOrderFormPage
		$I->waitForElementVisible("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']", 30); // stepKey: waitForAddProductButton
		$I->waitForPageLoad(30); // stepKey: waitForAddProductButtonWaitForPageLoad
		$I->comment("Entering Action Group [addFirstProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddFirstProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddFirstProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('createFirstProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddFirstProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddFirstProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchAddFirstProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddFirstProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddFirstProductToOrder
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "1"); // stepKey: fillProductQtyAddFirstProductToOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddFirstProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddFirstProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddFirstProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddFirstProductToOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddFirstProductToOrder
		$I->comment("Exiting Action Group [addFirstProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->waitForElementVisible("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']", 30); // stepKey: waitForAddProductButtonAfterOneProductIsAdded
		$I->waitForPageLoad(30); // stepKey: waitForAddProductButtonAfterOneProductIsAddedWaitForPageLoad
		$I->comment("Entering Action Group [addSecondProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddSecondProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddSecondProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('createSecondProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddSecondProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddSecondProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchAddSecondProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddSecondProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddSecondProductToOrder
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "1"); // stepKey: fillProductQtyAddSecondProductToOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddSecondProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddSecondProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddSecondProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddSecondProductToOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddSecondProductToOrder
		$I->comment("Exiting Action Group [addSecondProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->comment("Fill customer group and customer email");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [fillCustomerEmail] AdminFillAccountInformationOnCreateOrderPageActionGroup");
		$I->selectOption("#group_id", "General"); // stepKey: selectCustomerGroupFillCustomerEmail
		$I->fillField("#email", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: fillCustomerEmailFillCustomerEmail
		$I->comment("Exiting Action Group [fillCustomerEmail] AdminFillAccountInformationOnCreateOrderPageActionGroup");
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
		$I->comment("Select shipping");
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
		$I->comment("Submit Order and verify information");
		$I->comment("Entering Action Group [submitOrder] AdminSubmitOrderActionGroup");
		$I->scrollTo("#submit_order_top_button"); // stepKey: scrollToSubmitButtonSubmitOrder
		$I->waitForPageLoad(60); // stepKey: scrollToSubmitButtonSubmitOrderWaitForPageLoad
		$I->click("#submit_order_top_button"); // stepKey: submitOrderSubmitOrder
		$I->waitForPageLoad(60); // stepKey: submitOrderSubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSubmitOrder
		$I->see("You created the order."); // stepKey: seeSuccessMessageForOrderSubmitOrder
		$I->comment("Exiting Action Group [submitOrder] AdminSubmitOrderActionGroup");
		$I->comment("Grab tax amounts");
		$I->comment("need check selector");
		$amountOfTaxOnFirstProduct = $I->grabTextFrom("//table[contains(@class,'edit-order-table')]//div[contains(text(),'" . $I->retrieveEntityField('createFirstProduct', 'name', 'test') . "')]/ancestor::tr//td[contains(@class, 'col-tax-amount')]//span"); // stepKey: amountOfTaxOnFirstProduct
		$amountOfTaxOnSecondProduct = $I->grabTextFrom("//table[contains(@class,'edit-order-table')]//div[contains(text(),'" . $I->retrieveEntityField('createSecondProduct', 'name', 'test') . "')]/ancestor::tr//td[contains(@class, 'col-tax-amount')]//span"); // stepKey: amountOfTaxOnSecondProduct
		$amountOfTotalTax = $I->grabTextFrom("//table[contains(@class, 'order-subtotal-table')]/tbody/tr/td/div[contains(text(), 'Tax')]/ancestor::tr/td/span[contains(@class, 'price')]"); // stepKey: amountOfTotalTax
		$I->comment("Create Invoice and Shipment for this Order.");
		$I->comment("Entering Action Group [startCreatingInvoice] StartCreateInvoiceFromOrderPageActionGroup");
		$I->click("#order_invoice"); // stepKey: clickInvoiceActionStartCreatingInvoice
		$I->waitForPageLoad(30); // stepKey: clickInvoiceActionStartCreatingInvoiceWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_invoice/new/order_id/"); // stepKey: seeNewInvoiceUrlStartCreatingInvoice
		$I->see("New Invoice", ".page-header h1.page-title"); // stepKey: seeNewInvoicePageTitleStartCreatingInvoice
		$I->comment("Exiting Action Group [startCreatingInvoice] StartCreateInvoiceFromOrderPageActionGroup");
		$I->comment("Entering Action Group [clickSubmitInvoice] SubmitInvoiceActionGroup");
		$I->click(".action-default.scalable.save.submit-button.primary"); // stepKey: clickSubmitInvoiceClickSubmitInvoice
		$I->waitForPageLoad(60); // stepKey: clickSubmitInvoiceClickSubmitInvoiceWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageAppearsClickSubmitInvoice
		$I->see("The invoice has been created.", "#messages div.message-success"); // stepKey: seeInvoiceCreateSuccessClickSubmitInvoice
		$grabOrderIdClickSubmitInvoice = $I->grabFromCurrentUrl("~/order_id/(\d+)/~"); // stepKey: grabOrderIdClickSubmitInvoice
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/"); // stepKey: seeViewOrderPageInvoiceClickSubmitInvoice
		$I->comment("Exiting Action Group [clickSubmitInvoice] SubmitInvoiceActionGroup");
		$I->comment("Entering Action Group [seeShipmentOrderPage] GoToShipmentIntoOrderActionGroup");
		$I->click("#order_ship"); // stepKey: clickShipActionSeeShipmentOrderPage
		$I->waitForPageLoad(30); // stepKey: clickShipActionSeeShipmentOrderPageWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/order_shipment/new/order_id/"); // stepKey: seeOrderShipmentUrlSeeShipmentOrderPage
		$I->see("New Shipment", ".page-header h1.page-title"); // stepKey: seePageNameNewInvoicePageSeeShipmentOrderPage
		$I->comment("Exiting Action Group [seeShipmentOrderPage] GoToShipmentIntoOrderActionGroup");
		$I->comment("Submit Shipment");
		$I->comment("Entering Action Group [clickSubmitShipment] SubmitShipmentIntoOrderActionGroup");
		$I->click("button.action-default.save.submit-button"); // stepKey: clickSubmitShipmentClickSubmitShipment
		$I->waitForPageLoad(60); // stepKey: clickSubmitShipmentClickSubmitShipmentWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/"); // stepKey: seeViewOrderPageShippingClickSubmitShipment
		$I->see("The shipment has been created.", "div.message-success"); // stepKey: seeShipmentCreateSuccessClickSubmitShipment
		$I->comment("Exiting Action Group [clickSubmitShipment] SubmitShipmentIntoOrderActionGroup");
		$I->comment("Go to \"Reports\" -> \"Sales\" -> \"Tax\"");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/reports/report_sales/tax/"); // stepKey: navigateToReportsTaxPage
		$I->waitForPageLoad(30); // stepKey: waitForReportsTaxPageLoad
		$I->comment("click \"here\" to refresh last day's statistics");
		$I->click("//a[contains(text(),'here')]"); // stepKey: clickRefreshStatistics
		$I->waitForPageLoad(30); // stepKey: waitForRefresh
		$I->comment("Select Dates");
		$date = new \DateTime();
		$date->setTimestamp(strtotime("+0 day"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$today = $date->format("m/d/Y");

		$I->fillField("#sales_report_from", $today); // stepKey: fillDateFrom
		$I->fillField("#sales_report_to", $today); // stepKey: fillDateTo
		$I->comment("Click \"Show report\" in the upper right corner.");
		$I->click("#filter_form_submit"); // stepKey: clickShowReportButton
		$I->waitForPageLoad(60); // stepKey: waitForReload
		$I->comment("Tax Report Grid displays Tax amount in rows. \"Total\" and \"Subtotal\" is a sum of all tax amounts");
		$I->see("$amountOfTaxOnFirstProduct", "//*[contains(text(),'Tax Rate " . msq("TaxRateTexas") . "')]/following-sibling::td[contains(@class, 'col-tax-amount')]"); // stepKey: assertSubtotalFirstField
		$I->see("$amountOfTaxOnSecondProduct", "//*[contains(text(),'Tax Rate " . msq("SecondTaxRateTexas") . "')]/following-sibling::td[contains(@class, 'col-tax-amount')]"); // stepKey: assertSubtotalSecondField
		$I->see("$amountOfTotalTax", "//*[contains(text(),'Subtotal')]/following-sibling::td[contains(@class, 'col-tax-amount')]"); // stepKey: assertSubtotalField
	}
}
