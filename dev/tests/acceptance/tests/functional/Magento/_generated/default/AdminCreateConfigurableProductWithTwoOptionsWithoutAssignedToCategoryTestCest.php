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
 * @Title("MC-13686: Create configurable product with two new options without assigned to category with not visible child products")
 * @Description("Admin should be able to create configurable product with two options without assigned to category, child products are not visible individually<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminCreateConfigurableProductWithTwoOptionsWithoutAssignedToCategoryTest.xml<br>")
 * @TestCaseId("MC-13686")
 * @group mtf_migrated
 */
class AdminCreateConfigurableProductWithTwoOptionsWithoutAssignedToCategoryTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete configurable product");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct
		$I->fillField("input.admin__control-text[name='sku']", "api-configurable-product" . msq("ApiConfigurableProduct")); // stepKey: fillProductSkuFilterDeleteProduct
		$I->fillField("input.admin__control-text[name='name']", "API Configurable Product" . msq("ApiConfigurableProduct")); // stepKey: fillProductNameFilterDeleteProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductWaitForPageLoad
		$I->see("api-configurable-product" . msq("ApiConfigurableProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteProduct
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductWaitForPageLoad
		$I->comment("Exiting Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("Delete children products");
		$I->comment("Entering Action Group [deleteFirstChildProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteFirstChildProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteFirstChildProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteFirstChildProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteFirstChildProduct
		$I->fillField("input.admin__control-text[name='sku']", "sku-green" . msq("colorConfigurableProductAttribute1")); // stepKey: fillProductSkuFilterDeleteFirstChildProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteFirstChildProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteFirstChildProductWaitForPageLoad
		$I->see("sku-green" . msq("colorConfigurableProductAttribute1"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteFirstChildProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteFirstChildProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteFirstChildProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteFirstChildProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteFirstChildProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteFirstChildProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteFirstChildProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteFirstChildProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteFirstChildProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteFirstChildProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteFirstChildProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteFirstChildProduct
		$I->comment("Exiting Action Group [deleteFirstChildProduct] DeleteProductBySkuActionGroup");
		$I->comment("Entering Action Group [deleteSecondChildProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteSecondChildProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteSecondChildProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteSecondChildProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteSecondChildProduct
		$I->fillField("input.admin__control-text[name='sku']", "sku-red" . msq("colorConfigurableProductAttribute2")); // stepKey: fillProductSkuFilterDeleteSecondChildProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteSecondChildProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteSecondChildProductWaitForPageLoad
		$I->see("sku-red" . msq("colorConfigurableProductAttribute2"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteSecondChildProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteSecondChildProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteSecondChildProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteSecondChildProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteSecondChildProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteSecondChildProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteSecondChildProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteSecondChildProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteSecondChildProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteSecondChildProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteSecondChildProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteSecondChildProduct
		$I->comment("Exiting Action Group [deleteSecondChildProduct] DeleteProductBySkuActionGroup");
		$I->comment("Delete product attribute");
		$I->comment("Entering Action Group [deleteProductAttribute] AdminDeleteProductAttributeByLabelActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteProductAttribute
		$I->waitForPageLoad(30); // stepKey: waitForProductAttributeGridPageLoadDeleteProductAttribute
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridDeleteProductAttribute
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridDeleteProductAttributeWaitForPageLoad
		$I->fillField("//input[@name='frontend_label']", "Color" . msq("colorProductAttribute")); // stepKey: setAttributeLabelFilterDeleteProductAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeLabelFromTheGridDeleteProductAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeLabelFromTheGridDeleteProductAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteProductAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteProductAttributeWaitForPageLoad
		$I->click("#delete"); // stepKey: clickOnDeleteAttributeButtonDeleteProductAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteAttributeButtonDeleteProductAttributeWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmationPopUpVisibleDeleteProductAttribute
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOnConfirmationButtonDeleteProductAttribute
		$I->waitForPageLoad(60); // stepKey: clickOnConfirmationButtonDeleteProductAttributeWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageVisibleDeleteProductAttribute
		$I->see("You deleted the product attribute.", "#messages div.message-success"); // stepKey: seeAttributeDeleteSuccessMessageDeleteProductAttribute
		$I->comment("Exiting Action Group [deleteProductAttribute] AdminDeleteProductAttributeByLabelActionGroup");
		$I->comment("Delete attribute set");
		$I->comment("Entering Action Group [deleteAttributeSet] DeleteAttributeSetByLabelActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: goToAttributeSetsDeleteAttributeSet
		$I->waitForPageLoad(30); // stepKey: waitForAttributeSetPageLoadDeleteAttributeSet
		$I->fillField("#setGrid_filter_set_name", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: filterByNameDeleteAttributeSet
		$I->click("#container button[title='Search']"); // stepKey: clickSearchDeleteAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteAttributeSetWaitForPageLoad
		$I->click("#setGrid_table tbody tr:nth-of-type(1)"); // stepKey: clickFirstRowDeleteAttributeSet
		$I->waitForPageLoad(30); // stepKey: waitForClickDeleteAttributeSet
		$I->click("button[title='Delete']"); // stepKey: clickDeleteDeleteAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteAttributeSetWaitForPageLoad
		$I->click("button.action-accept"); // stepKey: confirmDeleteDeleteAttributeSet
		$I->waitForPageLoad(30); // stepKey: confirmDeleteDeleteAttributeSetWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteToFinishDeleteAttributeSet
		$I->see("The attribute set has been removed.", ".message-success"); // stepKey: seeDeleteMessageDeleteAttributeSet
		$I->comment("Exiting Action Group [deleteAttributeSet] DeleteAttributeSetByLabelActionGroup");
		$I->comment("Log out");
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
	 * @Features({"ConfigurableProduct"})
	 * @Stories({"Create configurable product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateConfigurableProductWithTwoOptionsWithoutAssignedToCategoryTest(AcceptanceTester $I)
	{
		$I->comment("Create configurable product");
		$I->comment("Entering Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductGridPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductGridPage
		$I->comment("Exiting Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [createConfigurableProduct] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleCreateConfigurableProductWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-configurable']", 30); // stepKey: waitForAddProductDropdownCreateConfigurableProduct
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-configurable']"); // stepKey: clickAddProductTypeCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadCreateConfigurableProduct
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/configurable/"); // stepKey: seeNewProductUrlCreateConfigurableProduct
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleCreateConfigurableProduct
		$I->comment("Exiting Action Group [createConfigurableProduct] GoToCreateProductPageActionGroup");
		$I->comment("Fill configurable product values");
		$I->comment("Entering Action Group [fillConfigurableProductValues] FillMainProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillConfigurableProductValues
		$I->fillField(".admin__field[data-index=name] input", "API Configurable Product" . msq("ApiConfigurableProduct")); // stepKey: fillProductNameFillConfigurableProductValues
		$I->fillField(".admin__field[data-index=sku] input", "api-configurable-product" . msq("ApiConfigurableProduct")); // stepKey: fillProductSkuFillConfigurableProductValues
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillConfigurableProductValues
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillConfigurableProductValues
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillConfigurableProductValues
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillConfigurableProductValuesWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillConfigurableProductValues
		$I->fillField(".admin__field[data-index=weight] input", "2"); // stepKey: fillProductWeightFillConfigurableProductValues
		$I->comment("Exiting Action Group [fillConfigurableProductValues] FillMainProductFormActionGroup");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsWaitForPageLoad
		$I->waitForElementVisible(".select-attributes-actions button[title='Create New Attribute']", 30); // stepKey: waitForConfigurationModalOpen
		$I->waitForPageLoad(30); // stepKey: waitForConfigurationModalOpenWaitForPageLoad
		$I->comment("Create product configurations");
		$I->comment("Create new attribute with two option");
		$I->comment("Entering Action Group [createProductConfigurationAttribute] AddNewProductConfigurationAttributeActionGroup");
		$I->comment("Create new attribute");
		$I->click(".select-attributes-actions button[title='Create New Attribute']"); // stepKey: clickOnNewAttributeCreateProductConfigurationAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnNewAttributeCreateProductConfigurationAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForIFrameCreateProductConfigurationAttribute
		$I->switchToIFrame("create_new_attribute_container"); // stepKey: switchToNewAttributeIFrameCreateProductConfigurationAttribute
		$I->fillField("input[name='frontend_label[0]']", "Color" . msq("colorProductAttribute")); // stepKey: fillDefaultLabelCreateProductConfigurationAttribute
		$I->click("#save"); // stepKey: clickOnNewAttributePanelCreateProductConfigurationAttribute
		$I->waitForPageLoad(30); // stepKey: waitForSaveAttributeCreateProductConfigurationAttribute
		$I->switchToIFrame(); // stepKey: switchOutOfIFrameCreateProductConfigurationAttribute
		$I->waitForPageLoad(30); // stepKey: waitForFiltersCreateProductConfigurationAttribute
		$I->comment("Find created below attribute and add option; save attribute");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickOnFiltersCreateProductConfigurationAttribute
		$I->fillField(".admin__control-text[name='attribute_code']", "Color" . msq("colorProductAttribute")); // stepKey: fillFilterAttributeCodeFieldCreateProductConfigurationAttribute
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonCreateProductConfigurationAttribute
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonCreateProductConfigurationAttributeWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxCreateProductConfigurationAttribute
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButtonCreateProductConfigurationAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonCreateProductConfigurationAttributeWaitForPageLoad
		$I->waitForElementVisible(".action-create-new", 30); // stepKey: waitCreateNewValueAppearsCreateProductConfigurationAttribute
		$I->waitForPageLoad(30); // stepKey: waitCreateNewValueAppearsCreateProductConfigurationAttributeWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateFirstNewValueCreateProductConfigurationAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnCreateFirstNewValueCreateProductConfigurationAttributeWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "Green" . msq("colorConfigurableProductAttribute1")); // stepKey: fillFieldForNewFirstOptionCreateProductConfigurationAttribute
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveNewAttributeCreateProductConfigurationAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnSaveNewAttributeCreateProductConfigurationAttributeWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateSecondNewValueCreateProductConfigurationAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnCreateSecondNewValueCreateProductConfigurationAttributeWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "Red" . msq("colorConfigurableProductAttribute2")); // stepKey: fillFieldForNewSecondOptionCreateProductConfigurationAttribute
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveAttributeCreateProductConfigurationAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAttributeCreateProductConfigurationAttributeWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllCreateProductConfigurationAttribute
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnSecondNextButtonCreateProductConfigurationAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnSecondNextButtonCreateProductConfigurationAttributeWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnThirdNextButtonCreateProductConfigurationAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnThirdNextButtonCreateProductConfigurationAttributeWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnFourthNextButtonCreateProductConfigurationAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnFourthNextButtonCreateProductConfigurationAttributeWaitForPageLoad
		$I->comment("Exiting Action Group [createProductConfigurationAttribute] AddNewProductConfigurationAttributeActionGroup");
		$I->comment("Change product configurations in grid");
		$I->comment("Entering Action Group [changeProductConfigurationsInGrid] ChangeProductConfigurationsInGridActionGroup");
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Green" . msq("colorConfigurableProductAttribute1") . "')]/ancestor::tr/td[@data-index='name_container']//input", "Green" . msq("colorConfigurableProductAttribute1")); // stepKey: fillFieldNameForFirstAttributeOptionChangeProductConfigurationsInGrid
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Red" . msq("colorConfigurableProductAttribute2") . "')]/ancestor::tr/td[@data-index='name_container']//input", "Red" . msq("colorConfigurableProductAttribute2")); // stepKey: fillFieldNameForSecondAttributeOptionChangeProductConfigurationsInGrid
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Green" . msq("colorConfigurableProductAttribute1") . "')]/ancestor::tr/td[@data-index='sku_container']//input", "sku-green" . msq("colorConfigurableProductAttribute1")); // stepKey: fillFieldSkuForFirstAttributeOptionChangeProductConfigurationsInGrid
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Red" . msq("colorConfigurableProductAttribute2") . "')]/ancestor::tr/td[@data-index='sku_container']//input", "sku-red" . msq("colorConfigurableProductAttribute2")); // stepKey: fillFieldSkuForSecondAttributeOptionChangeProductConfigurationsInGrid
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Green" . msq("colorConfigurableProductAttribute1") . "')]/ancestor::tr/td[@data-index='price_container']//input", "1"); // stepKey: fillFieldPriceForFirstAttributeOptionChangeProductConfigurationsInGrid
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Red" . msq("colorConfigurableProductAttribute2") . "')]/ancestor::tr/td[@data-index='price_container']//input", "2"); // stepKey: fillFieldPriceForSecondAttributeOptionChangeProductConfigurationsInGrid
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Green" . msq("colorConfigurableProductAttribute1") . "')]/ancestor::tr/td[@data-index='quantity_container']//input", "1"); // stepKey: fillFieldQuantityForFirstAttributeOptionChangeProductConfigurationsInGrid
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Red" . msq("colorConfigurableProductAttribute2") . "')]/ancestor::tr/td[@data-index='quantity_container']//input", "10"); // stepKey: fillFieldQuantityForSecondAttributeOptionChangeProductConfigurationsInGrid
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Green" . msq("colorConfigurableProductAttribute1") . "')]/ancestor::tr/td[@data-index='price_weight']//input", "1"); // stepKey: fillFieldWeightForFirstAttributeOptionChangeProductConfigurationsInGrid
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Red" . msq("colorConfigurableProductAttribute2") . "')]/ancestor::tr/td[@data-index='price_weight']//input", "1"); // stepKey: fillFieldWeightForSecondAttributeOptionChangeProductConfigurationsInGrid
		$I->comment("Exiting Action Group [changeProductConfigurationsInGrid] ChangeProductConfigurationsInGridActionGroup");
		$I->comment("Save configurable product; add product to new attribute set");
		$I->comment("Entering Action Group [saveConfigurableProduct] SaveConfigurableProductWithNewAttributeSetActionGroup");
		$I->click("#save-button"); // stepKey: clickSaveConfigurableProductSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveConfigurableProductSaveConfigurableProductWaitForPageLoad
		$I->waitForElementVisible("button[data-index='confirm_button']", 30); // stepKey: waitForAttributeSetConfirmationSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForAttributeSetConfirmationSaveConfigurableProductWaitForPageLoad
		$I->click("//input[@data-index='affectedAttributeSetNew']"); // stepKey: clickAddNewAttributeSetSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickAddNewAttributeSetSaveConfigurableProductWaitForPageLoad
		$I->fillField("//input[@name='configurableNewAttributeSetName']", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: fillFieldNewAttrSetNameSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: fillFieldNewAttrSetNameSaveConfigurableProductWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickConfirmAttributeSetSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickConfirmAttributeSetSaveConfigurableProductWaitForPageLoad
		$I->see("You saved the product"); // stepKey: seeConfigurableSaveConfirmationSaveConfigurableProduct
		$I->comment("Exiting Action Group [saveConfigurableProduct] SaveConfigurableProductWithNewAttributeSetActionGroup");
		$I->comment("Assert Child Products in grid");
		$I->comment("Entering Action Group [viewFirstChildProductInAdminGrid] ViewProductInAdminGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageViewFirstChildProductInAdminGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadInitialViewFirstChildProductInAdminGrid
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialViewFirstChildProductInAdminGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialViewFirstChildProductInAdminGridWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersViewFirstChildProductInAdminGrid
		$I->fillField("input.admin__control-text[name='name']", "Green" . msq("colorConfigurableProductAttribute1")); // stepKey: fillProductNameFilterViewFirstChildProductInAdminGrid
		$I->fillField("input.admin__control-text[name='sku']", "sku-green" . msq("colorConfigurableProductAttribute1")); // stepKey: fillProductSkuFilterViewFirstChildProductInAdminGrid
		$I->selectOption("select.admin__control-select[name='type_id']", "simple"); // stepKey: selectionProductTypeViewFirstChildProductInAdminGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersViewFirstChildProductInAdminGrid
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersViewFirstChildProductInAdminGridWaitForPageLoad
		$I->see("Green" . msq("colorConfigurableProductAttribute1"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Name']/preceding-sibling::th) +1 ]"); // stepKey: seeProductNameInGridViewFirstChildProductInAdminGrid
		$I->see("1", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Price']/preceding-sibling::th) +1 ]"); // stepKey: seeProductPriceInGridViewFirstChildProductInAdminGrid
		$I->click(".admin__data-grid-header button[data-action='grid-filter-reset']"); // stepKey: clickClearFiltersAfterViewFirstChildProductInAdminGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAfterViewFirstChildProductInAdminGridWaitForPageLoad
		$I->comment("Exiting Action Group [viewFirstChildProductInAdminGrid] ViewProductInAdminGridActionGroup");
		$I->comment("Entering Action Group [viewSecondChildProductInAdminGrid] ViewProductInAdminGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageViewSecondChildProductInAdminGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadInitialViewSecondChildProductInAdminGrid
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialViewSecondChildProductInAdminGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialViewSecondChildProductInAdminGridWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersViewSecondChildProductInAdminGrid
		$I->fillField("input.admin__control-text[name='name']", "Red" . msq("colorConfigurableProductAttribute2")); // stepKey: fillProductNameFilterViewSecondChildProductInAdminGrid
		$I->fillField("input.admin__control-text[name='sku']", "sku-red" . msq("colorConfigurableProductAttribute2")); // stepKey: fillProductSkuFilterViewSecondChildProductInAdminGrid
		$I->selectOption("select.admin__control-select[name='type_id']", "simple"); // stepKey: selectionProductTypeViewSecondChildProductInAdminGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersViewSecondChildProductInAdminGrid
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersViewSecondChildProductInAdminGridWaitForPageLoad
		$I->see("Red" . msq("colorConfigurableProductAttribute2"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Name']/preceding-sibling::th) +1 ]"); // stepKey: seeProductNameInGridViewSecondChildProductInAdminGrid
		$I->see("2", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Price']/preceding-sibling::th) +1 ]"); // stepKey: seeProductPriceInGridViewSecondChildProductInAdminGrid
		$I->click(".admin__data-grid-header button[data-action='grid-filter-reset']"); // stepKey: clickClearFiltersAfterViewSecondChildProductInAdminGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAfterViewSecondChildProductInAdminGridWaitForPageLoad
		$I->comment("Exiting Action Group [viewSecondChildProductInAdminGrid] ViewProductInAdminGridActionGroup");
		$I->comment("Assert Configurable Product in grid");
		$I->comment("Entering Action Group [findCreatedConfigurableProduct] FilterProductGridBySkuAndNameActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialFindCreatedConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialFindCreatedConfigurableProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFindCreatedConfigurableProduct
		$I->fillField("input.admin__control-text[name='sku']", "api-configurable-product" . msq("ApiConfigurableProduct")); // stepKey: fillProductSkuFilterFindCreatedConfigurableProduct
		$I->fillField("input.admin__control-text[name='name']", "API Configurable Product" . msq("ApiConfigurableProduct")); // stepKey: fillProductNameFilterFindCreatedConfigurableProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFindCreatedConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFindCreatedConfigurableProductWaitForPageLoad
		$I->comment("Exiting Action Group [findCreatedConfigurableProduct] FilterProductGridBySkuAndNameActionGroup");
		$I->comment("Entering Action Group [seeProductTypeInGrid] AssertAdminProductGridCellActionGroup");
		$I->see("configurable", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Type']/preceding-sibling::th) +1 ]"); // stepKey: seeProductGridCellWithProvidedValueSeeProductTypeInGrid
		$I->comment("Exiting Action Group [seeProductTypeInGrid] AssertAdminProductGridCellActionGroup");
		$I->click(".admin__data-grid-header button[data-action='grid-filter-reset']"); // stepKey: clickClearFiltersAfter
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAfterWaitForPageLoad
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Assert configurable product on product page");
		$I->amOnPage("api-configurable-product" . msq("ApiConfigurableProduct") . ".html"); // stepKey: amOnProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->comment("Entering Action Group [checkConfigurableProductOptions] StorefrontCheckConfigurableProductOptionsActionGroup");
		$I->selectOption("#product-options-wrapper .super-attribute-select", "Green" . msq("colorConfigurableProductAttribute1")); // stepKey: selectOption1CheckConfigurableProductOptions
		$I->see("API Configurable Product" . msq("ApiConfigurableProduct"), ".base"); // stepKey: seeConfigurableProductNameCheckConfigurableProductOptions
		$I->see("1", "div.price-box.price-final_price"); // stepKey: assertProductPricePresentCheckConfigurableProductOptions
		$I->see("api-configurable-product" . msq("ApiConfigurableProduct"), ".product.attribute.sku>.value"); // stepKey: seeConfigurableProductSkuCheckConfigurableProductOptions
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStockCheckConfigurableProductOptions
		$I->see("Color" . msq("colorProductAttribute"), "#product-options-wrapper div[tabindex='0'] label"); // stepKey: seeColorAttributeNameCheckConfigurableProductOptions
		$I->dontSee("As low as", ".price-label"); // stepKey: dontSeeProductPriceLabel1CheckConfigurableProductOptions
		$I->selectOption("#product-options-wrapper .super-attribute-select", "Red" . msq("colorConfigurableProductAttribute2")); // stepKey: selectOption2CheckConfigurableProductOptions
		$I->dontSee("As low as", ".price-label"); // stepKey: dontSeeProductPriceLabel2CheckConfigurableProductOptions
		$I->see("2", "div.price-box.price-final_price"); // stepKey: seeProductPrice2CheckConfigurableProductOptions
		$I->comment("Exiting Action Group [checkConfigurableProductOptions] StorefrontCheckConfigurableProductOptionsActionGroup");
		$I->comment("Add configurable product to the cart with selected first option");
		$I->selectOption("#product-options-wrapper .super-attribute-select", "Green" . msq("colorConfigurableProductAttribute1")); // stepKey: selectOptionForAddingToCart
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessage
		$I->comment("Assert configurable product in cart");
		$I->comment("Entering Action Group [amOnShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageAmOnShoppingCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedAmOnShoppingCartPage
		$I->comment("Exiting Action Group [amOnShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [storefrontCheckCartConfigurableProductActionGroup] StorefrontCheckCartConfigurableProductActionGroup");
		$I->seeElement("//main//table[@id='shopping-cart-table']//tbody//tr//strong[contains(@class, 'product-item-name')]//a[contains(text(), 'API Configurable Product" . msq("ApiConfigurableProduct") . "')]"); // stepKey: assertProductNameStorefrontCheckCartConfigurableProductActionGroup
		$I->see("$1.00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='API Configurable Product" . msq("ApiConfigurableProduct") . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: assertProductPriceStorefrontCheckCartConfigurableProductActionGroup
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='API Configurable Product" . msq("ApiConfigurableProduct") . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "1"); // stepKey: assertProductQuantityStorefrontCheckCartConfigurableProductActionGroup
		$I->comment("Exiting Action Group [storefrontCheckCartConfigurableProductActionGroup] StorefrontCheckCartConfigurableProductActionGroup");
		$I->comment("Assert child products are not displayed separately: two next step");
		$I->comment("Entering Action Group [goToStoreFront] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStoreFront
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStoreFront
		$I->comment("Exiting Action Group [goToStoreFront] StorefrontOpenHomePageActionGroup");
		$I->comment("Quick search the storefront for the first attribute option");
		$I->submitForm("#search_mini_form", ['q' => "sku-green" . msq("colorConfigurableProductAttribute1")]); // stepKey: searchStorefrontFirstChildProduct
		$I->dontSee("//main//li//a[contains(text(), 'Green" . msq("colorConfigurableProductAttribute1") . "')]"); // stepKey: dontSeeConfigurableProductFirstChild
		$I->comment("Quick search the storefront for the second attribute option");
		$I->submitForm("#search_mini_form", ['q' => "sku-red" . msq("colorConfigurableProductAttribute2")]); // stepKey: searchStorefrontSecondChildProduct
		$I->dontSee("//main//li//a[contains(text(), 'Red" . msq("colorConfigurableProductAttribute2") . "')]"); // stepKey: dontSeeConfigurableProductSecondChild
	}
}
