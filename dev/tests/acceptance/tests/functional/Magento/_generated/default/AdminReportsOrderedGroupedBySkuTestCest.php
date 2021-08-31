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
 * @Title("[NO TESTCASEID]: Verify grouped by SKU on report")
 * @Description("Verify the list of configurable product grouped by SKU, on report page 'Reports > Products > Ordered'<h3>Test files</h3>app/code/Magento/Reports/Test/Mftf/Test/AdminReportsOrderedGroupedBySkuTest.xml<br>")
 * @group reports
 */
class AdminReportsOrderedGroupedBySkuTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [createConfigurableProduct] CreateConfigurableProductActionGroup");
		$I->comment("fill in basic configurable product values");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: amOnProductGridPageCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: wait1CreateConfigurableProduct
		$I->click(".action-toggle.primary.add"); // stepKey: clickOnAddProductToggleCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnAddProductToggleCreateConfigurableProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-configurable']"); // stepKey: clickOnAddConfigurableProductCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnAddConfigurableProductCreateConfigurableProductWaitForPageLoad
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillNameCreateConfigurableProduct
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillSKUCreateConfigurableProduct
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillPriceCreateConfigurableProduct
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillQuantityCreateConfigurableProduct
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'hook')]); // stepKey: fillCategoryCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: fillCategoryCreateConfigurableProductWaitForPageLoad
		$I->selectOption("//select[@name='product[visibility]']", "4"); // stepKey: fillVisibilityCreateConfigurableProduct
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSectionCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: openSeoSectionCreateConfigurableProductWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", "testproductname" . msq("_defaultProduct")); // stepKey: fillUrlKeyCreateConfigurableProduct
		$I->comment("create configurations for colors the product is available in");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickOnCreateConfigurationsCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnCreateConfigurationsCreateConfigurableProductWaitForPageLoad
		$I->click(".select-attributes-actions button[title='Create New Attribute']"); // stepKey: clickOnNewAttributeCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNewAttributeCreateConfigurableProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForIFrameCreateConfigurableProduct
		$I->switchToIFrame("create_new_attribute_container"); // stepKey: switchToNewAttributeIFrameCreateConfigurableProduct
		$I->fillField("input[name='frontend_label[0]']", "Color" . msq("colorProductAttribute")); // stepKey: fillDefaultLabelCreateConfigurableProduct
		$I->click("#save"); // stepKey: clickOnNewAttributePanelCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveAttributeCreateConfigurableProduct
		$I->switchToIFrame(); // stepKey: switchOutOfIFrameCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForFiltersCreateConfigurableProduct
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickOnFiltersCreateConfigurableProduct
		$I->fillField(".admin__control-text[name='attribute_code']", "Color" . msq("colorProductAttribute")); // stepKey: fillFilterAttributeCodeFieldCreateConfigurableProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonCreateConfigurableProductWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxCreateConfigurableProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1CreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1CreateConfigurableProductWaitForPageLoad
		$I->waitForElementVisible(".action-create-new", 30); // stepKey: waitCreateNewValueAppearsCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitCreateNewValueAppearsCreateConfigurableProductWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateNewValue1CreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnCreateNewValue1CreateConfigurableProductWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "White" . msq("colorProductAttribute1")); // stepKey: fillFieldForNewAttribute1CreateConfigurableProduct
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveNewAttribute1CreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnSaveNewAttribute1CreateConfigurableProductWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateNewValue2CreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnCreateNewValue2CreateConfigurableProductWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "Red" . msq("colorProductAttribute2")); // stepKey: fillFieldForNewAttribute2CreateConfigurableProduct
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveNewAttribute2CreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnSaveNewAttribute2CreateConfigurableProductWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateNewValue3CreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnCreateNewValue3CreateConfigurableProductWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "Blue" . msq("colorProductAttribute3")); // stepKey: fillFieldForNewAttribute3CreateConfigurableProduct
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveNewAttribute3CreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnSaveNewAttribute3CreateConfigurableProductWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllCreateConfigurableProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2CreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2CreateConfigurableProductWaitForPageLoad
		$I->click(".admin__field-label[for='apply-unique-prices-radio']"); // stepKey: clickOnApplyUniquePricesByAttributeToEachSkuCreateConfigurableProduct
		$I->selectOption("#select-each-price", "Color" . msq("colorProductAttribute")); // stepKey: selectAttributesCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: selectAttributesCreateConfigurableProductWaitForPageLoad
		$I->fillField("#apply-single-price-input-0", "1.00"); // stepKey: fillAttributePrice1CreateConfigurableProduct
		$I->fillField("#apply-single-price-input-1", "2.00"); // stepKey: fillAttributePrice2CreateConfigurableProduct
		$I->fillField("#apply-single-price-input-2", "3.00"); // stepKey: fillAttributePrice3CreateConfigurableProduct
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuCreateConfigurableProductWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "1"); // stepKey: enterAttributeQuantityCreateConfigurableProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3CreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3CreateConfigurableProductWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4CreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4CreateConfigurableProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButton2CreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButton2CreateConfigurableProductWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmInPopupCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupCreateConfigurableProductWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessageCreateConfigurableProduct
		$I->seeInTitle("testProductName" . msq("_defaultProduct")); // stepKey: seeProductNameInTitleCreateConfigurableProduct
		$I->comment("Exiting Action Group [createConfigurableProduct] CreateConfigurableProductActionGroup");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [deleteConfigurableProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteConfigurableProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteConfigurableProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteConfigurableProduct
		$I->fillField("input.admin__control-text[name='sku']", "testSku" . msq("_defaultProduct")); // stepKey: fillProductSkuFilterDeleteConfigurableProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteConfigurableProductWaitForPageLoad
		$I->see("testSku" . msq("_defaultProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteConfigurableProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteConfigurableProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteConfigurableProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteConfigurableProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteConfigurableProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteConfigurableProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteConfigurableProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteConfigurableProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteConfigurableProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteConfigurableProduct
		$I->comment("Exiting Action Group [deleteConfigurableProduct] DeleteProductBySkuActionGroup");
		$I->comment("Entering Action Group [clearGridFiltersVirtual] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopClearGridFiltersVirtual
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersClearGridFiltersVirtual
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetClearGridFiltersVirtual
		$I->comment("Exiting Action Group [clearGridFiltersVirtual] AdminGridFilterResetActionGroup");
		$I->comment("Entering Action Group [addSkuFilterVirtual] AdminGridFilterFillInputFieldActionGroup");
		$I->conditionalClick("//div[@class='admin__data-grid-header'][(not(ancestor::*[@class='sticky-header']) and not(contains(@style,'visibility: hidden'))) or (ancestor::*[@class='sticky-header' and not(contains(@style,'display: none'))])]//button[@data-action='grid-filter-expand']", "[data-part='filter-form']", false); // stepKey: openFiltersFormIfNecessaryAddSkuFilterVirtual
		$I->waitForElementVisible("[data-part='filter-form']", 30); // stepKey: waitForFormVisibleAddSkuFilterVirtual
		$I->fillField("//*[@data-part='filter-form']//input[@name='sku']", "testSku" . msq("_defaultProduct")); // stepKey: fillFilterInputFieldAddSkuFilterVirtual
		$I->comment("Exiting Action Group [addSkuFilterVirtual] AdminGridFilterFillInputFieldActionGroup");
		$I->comment("Entering Action Group [applyGridFilterVirtual] AdminClickSearchInGridActionGroup");
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchApplyGridFilterVirtual
		$I->waitForPageLoad(30); // stepKey: clickSearchApplyGridFilterVirtualWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultApplyGridFilterVirtual
		$I->comment("Exiting Action Group [applyGridFilterVirtual] AdminClickSearchInGridActionGroup");
		$I->comment("Entering Action Group [deleteVirtualProducts] DeleteProductsIfTheyExistActionGroup");
		$I->conditionalClick("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle", "table.data-grid tr.data-row:first-of-type", true); // stepKey: openMulticheckDropdownDeleteVirtualProducts
		$I->conditionalClick("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']", "table.data-grid tr.data-row:first-of-type", true); // stepKey: selectAllProductInFilteredGridDeleteVirtualProducts
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteVirtualProducts
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteVirtualProductsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteVirtualProducts
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteVirtualProductsWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm button.action-accept", 30); // stepKey: waitForModalPopUpDeleteVirtualProducts
		$I->waitForPageLoad(60); // stepKey: waitForModalPopUpDeleteVirtualProductsWaitForPageLoad
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteVirtualProducts
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteVirtualProductsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadDeleteVirtualProducts
		$I->comment("Exiting Action Group [deleteVirtualProducts] DeleteProductsIfTheyExistActionGroup");
		$I->comment("Entering Action Group [clearProductsGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearProductsGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearProductsGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductsGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [deleteAttributeSet] AdminDeleteProductAttributeByLabelActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteAttributeSet
		$I->waitForPageLoad(30); // stepKey: waitForProductAttributeGridPageLoadDeleteAttributeSet
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridDeleteAttributeSet
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridDeleteAttributeSetWaitForPageLoad
		$I->fillField("//input[@name='frontend_label']", "Color" . msq("colorProductAttribute")); // stepKey: setAttributeLabelFilterDeleteAttributeSet
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeLabelFromTheGridDeleteAttributeSet
		$I->waitForPageLoad(30); // stepKey: searchForAttributeLabelFromTheGridDeleteAttributeSetWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteAttributeSetWaitForPageLoad
		$I->click("#delete"); // stepKey: clickOnDeleteAttributeButtonDeleteAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteAttributeButtonDeleteAttributeSetWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmationPopUpVisibleDeleteAttributeSet
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOnConfirmationButtonDeleteAttributeSet
		$I->waitForPageLoad(60); // stepKey: clickOnConfirmationButtonDeleteAttributeSetWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageVisibleDeleteAttributeSet
		$I->see("You deleted the product attribute.", "#messages div.message-success"); // stepKey: seeAttributeDeleteSuccessMessageDeleteAttributeSet
		$I->comment("Exiting Action Group [deleteAttributeSet] AdminDeleteProductAttributeByLabelActionGroup");
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
	 * @Stories({"Grouped by SKU on report"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Reports"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminReportsOrderedGroupedBySkuTest(AcceptanceTester $I)
	{
		$I->comment("Add first configurable product to order");
		$I->comment("Entering Action Group [navigateToFirstOrderWithExistingCustomer] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageNavigateToFirstOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadNavigateToFirstOrderWithExistingCustomer
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleNavigateToFirstOrderWithExistingCustomer
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderNavigateToFirstOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderNavigateToFirstOrderWithExistingCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGridLoadNavigateToFirstOrderWithExistingCustomer
		$I->comment("Clear grid filters");
		$I->conditionalClick("#sales_order_create_customer_grid [data-action='grid-filter-reset']", "#sales_order_create_customer_grid [data-action='grid-filter-reset']", true); // stepKey: clearExistingCustomerFiltersNavigateToFirstOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: clearExistingCustomerFiltersNavigateToFirstOrderWithExistingCustomerWaitForPageLoad
		$I->fillField("#sales_order_create_customer_grid_filter_email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailNavigateToFirstOrderWithExistingCustomer
		$I->click(".action-secondary[title='Search']"); // stepKey: applyFilterNavigateToFirstOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForFilteredCustomerGridLoadNavigateToFirstOrderWithExistingCustomer
		$I->click("tr:nth-of-type(1)[data-role='row']"); // stepKey: clickOnCustomerNavigateToFirstOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadNavigateToFirstOrderWithExistingCustomer
		$I->comment("Select store view if appears");
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsNavigateToFirstOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsNavigateToFirstOrderWithExistingCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectNavigateToFirstOrderWithExistingCustomer
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleNavigateToFirstOrderWithExistingCustomer
		$I->comment("Exiting Action Group [navigateToFirstOrderWithExistingCustomer] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->comment("Entering Action Group [addFirstConfigurableProductToOrder] AddConfigurableProductToOrderActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageAddFirstConfigurableProductToOrder
		$I->waitForElementVisible("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']", 30); // stepKey: waitForAddProductsButtonAddFirstConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: waitForAddProductsButtonAddFirstConfigurableProductToOrderWaitForPageLoad
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddFirstConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddFirstConfigurableProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", "testSku" . msq("_defaultProduct")); // stepKey: fillSkuFilterConfigurableAddFirstConfigurableProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchConfigurableAddFirstConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchConfigurableAddFirstConfigurableProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddFirstConfigurableProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectConfigurableProductAddFirstConfigurableProductToOrder
		$I->waitForElementVisible("//div[contains(@class,'product-options')]//select[//label[text() = 'Color" . msq("colorProductAttribute") . "']]", 30); // stepKey: waitForConfigurablePopoverAddFirstConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: waitForConfigurablePopoverAddFirstConfigurableProductToOrderWaitForPageLoad
		$I->wait(2); // stepKey: waitForOptionsToLoadAddFirstConfigurableProductToOrder
		$I->selectOption("//div[contains(@class,'product-options')]//select[//label[text() = 'Color" . msq("colorProductAttribute") . "']]", "White" . msq("colorProductAttribute1")); // stepKey: selectionConfigurableOptionAddFirstConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: selectionConfigurableOptionAddFirstConfigurableProductToOrderWaitForPageLoad
		$I->click(".modal-header .page-actions button[data-role='action']"); // stepKey: clickOkConfigurablePopoverAddFirstConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickOkConfigurablePopoverAddFirstConfigurableProductToOrderWaitForPageLoad
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddFirstConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddFirstConfigurableProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddFirstConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddFirstConfigurableProductToOrderWaitForPageLoad
		$I->comment("Exiting Action Group [addFirstConfigurableProductToOrder] AddConfigurableProductToOrderActionGroup");
		$I->comment("Entering Action Group [submitFirstOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->click("#submit_order_top_button"); // stepKey: clickSubmitOrderSubmitFirstOrder
		$I->waitForPageLoad(30); // stepKey: clickSubmitOrderSubmitFirstOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoadSubmitFirstOrder
		$I->comment("Exiting Action Group [submitFirstOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->comment("Add second configurable product to order");
		$I->comment("Entering Action Group [navigateToSecondOrderWithExistingCustomer] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageNavigateToSecondOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadNavigateToSecondOrderWithExistingCustomer
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleNavigateToSecondOrderWithExistingCustomer
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderNavigateToSecondOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderNavigateToSecondOrderWithExistingCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGridLoadNavigateToSecondOrderWithExistingCustomer
		$I->comment("Clear grid filters");
		$I->conditionalClick("#sales_order_create_customer_grid [data-action='grid-filter-reset']", "#sales_order_create_customer_grid [data-action='grid-filter-reset']", true); // stepKey: clearExistingCustomerFiltersNavigateToSecondOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: clearExistingCustomerFiltersNavigateToSecondOrderWithExistingCustomerWaitForPageLoad
		$I->fillField("#sales_order_create_customer_grid_filter_email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailNavigateToSecondOrderWithExistingCustomer
		$I->click(".action-secondary[title='Search']"); // stepKey: applyFilterNavigateToSecondOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForFilteredCustomerGridLoadNavigateToSecondOrderWithExistingCustomer
		$I->click("tr:nth-of-type(1)[data-role='row']"); // stepKey: clickOnCustomerNavigateToSecondOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadNavigateToSecondOrderWithExistingCustomer
		$I->comment("Select store view if appears");
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsNavigateToSecondOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsNavigateToSecondOrderWithExistingCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectNavigateToSecondOrderWithExistingCustomer
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleNavigateToSecondOrderWithExistingCustomer
		$I->comment("Exiting Action Group [navigateToSecondOrderWithExistingCustomer] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->comment("Entering Action Group [addSecondConfigurableProductToOrder] AddConfigurableProductToOrderActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageAddSecondConfigurableProductToOrder
		$I->waitForElementVisible("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']", 30); // stepKey: waitForAddProductsButtonAddSecondConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: waitForAddProductsButtonAddSecondConfigurableProductToOrderWaitForPageLoad
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddSecondConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddSecondConfigurableProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", "testSku" . msq("_defaultProduct")); // stepKey: fillSkuFilterConfigurableAddSecondConfigurableProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchConfigurableAddSecondConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchConfigurableAddSecondConfigurableProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddSecondConfigurableProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectConfigurableProductAddSecondConfigurableProductToOrder
		$I->waitForElementVisible("//div[contains(@class,'product-options')]//select[//label[text() = 'Color" . msq("colorProductAttribute") . "']]", 30); // stepKey: waitForConfigurablePopoverAddSecondConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: waitForConfigurablePopoverAddSecondConfigurableProductToOrderWaitForPageLoad
		$I->wait(2); // stepKey: waitForOptionsToLoadAddSecondConfigurableProductToOrder
		$I->selectOption("//div[contains(@class,'product-options')]//select[//label[text() = 'Color" . msq("colorProductAttribute") . "']]", "Red" . msq("colorProductAttribute2")); // stepKey: selectionConfigurableOptionAddSecondConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: selectionConfigurableOptionAddSecondConfigurableProductToOrderWaitForPageLoad
		$I->click(".modal-header .page-actions button[data-role='action']"); // stepKey: clickOkConfigurablePopoverAddSecondConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickOkConfigurablePopoverAddSecondConfigurableProductToOrderWaitForPageLoad
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddSecondConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddSecondConfigurableProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddSecondConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddSecondConfigurableProductToOrderWaitForPageLoad
		$I->comment("Exiting Action Group [addSecondConfigurableProductToOrder] AddConfigurableProductToOrderActionGroup");
		$I->comment("Entering Action Group [submitSecondOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->click("#submit_order_top_button"); // stepKey: clickSubmitOrderSubmitSecondOrder
		$I->waitForPageLoad(30); // stepKey: clickSubmitOrderSubmitSecondOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoadSubmitSecondOrder
		$I->comment("Exiting Action Group [submitSecondOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->comment("Get date");
		$date = new \DateTime();
		$date->setTimestamp(strtotime("-1 minute"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$generateStartDate = $date->format("m/d/Y");

		$date = new \DateTime();
		$date->setTimestamp(strtotime("+1 minute"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$generateEndDate = $date->format("m/d/Y");

		$I->comment("Entering Action Group [generateReport] AdminGenerateProductsOrderedReportActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/reports/report_product/sold/"); // stepKey: navigateToOrderedProductPageGenerateReport
		$I->fillField("#gridProductsSold_period_date_from", "$generateStartDate"); // stepKey: fillFromDateGenerateReport
		$I->fillField("#gridProductsSold_period_date_to", "$generateEndDate"); // stepKey: fillToDateGenerateReport
		$I->click("//button/span[contains(text(),'Refresh')]"); // stepKey: clickRefreshGenerateReport
		$I->comment("Exiting Action Group [generateReport] AdminGenerateProductsOrderedReportActionGroup");
		$I->comment("Verify data");
		$grabData = $I->grabTextFrom("#gridProductsSold_table"); // stepKey: grabData
		$I->assertStringContainsString("testSku" . msq("_defaultProduct") . "-White" . msq("colorProductAttribute1"), $grabData); // stepKey: assertFirst
		$I->assertStringContainsString("testSku" . msq("_defaultProduct") . "-Red" . msq("colorProductAttribute2"), $grabData); // stepKey: assertSecond
	}
}
