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
 * @Title("MC-13687: Create configurable product with creating new category and new attribute (required fields only)")
 * @Description("Admin should be able to create configurable product with creating new category and new attribute (required fields only)<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminCreateConfigurableProductWithCreatingCategoryAndAttributeTest.xml<br>")
 * @TestCaseId("MC-13687")
 * @group mtf_migrated
 */
class AdminCreateConfigurableProductWithCreatingCategoryAndAttributeTestCest
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
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
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
		$I->comment("Delete category");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	public function AdminCreateConfigurableProductWithCreatingCategoryAndAttributeTest(AcceptanceTester $I)
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
		$I->comment("Fill configurable product required fields only");
		$I->fillField(".admin__field[data-index=name] input", "API Configurable Product" . msq("ApiConfigurableProduct")); // stepKey: fillProductName
		$I->fillField(".admin__field[data-index=sku] input", "api-configurable-product" . msq("ApiConfigurableProduct")); // stepKey: fillProductSku
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPrice
		$I->comment("Add configurable product in category");
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'test')]); // stepKey: fillCategory
		$I->waitForPageLoad(30); // stepKey: fillCategoryWaitForPageLoad
		$I->comment("Create product configurations");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsWaitForPageLoad
		$I->waitForElementVisible(".select-attributes-actions button[title='Create New Attribute']", 30); // stepKey: waitForConfigurationModalOpen
		$I->waitForPageLoad(30); // stepKey: waitForConfigurationModalOpenWaitForPageLoad
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
		$I->comment("Find configurable product in grid");
		$I->comment("Entering Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageVisitAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadVisitAdminProductPage
		$I->comment("Exiting Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [findCreatedConfigurableProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFindCreatedConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFindCreatedConfigurableProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFindCreatedConfigurableProduct
		$I->fillField("input.admin__control-text[name='sku']", "api-configurable-product" . msq("ApiConfigurableProduct")); // stepKey: fillProductSkuFilterFindCreatedConfigurableProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFindCreatedConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFindCreatedConfigurableProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFindCreatedConfigurableProduct
		$I->comment("Exiting Action Group [findCreatedConfigurableProduct] FilterProductGridBySkuActionGroup");
		$I->comment("Assert configurable product on admin product page");
		$I->comment("Entering Action Group [clickOnProductPage] AdminProductGridSectionClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickOnProductPageClickOnProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickOnProductPage
		$I->comment("Exiting Action Group [clickOnProductPage] AdminProductGridSectionClickFirstRowActionGroup");
		$I->comment("Entering Action Group [assertConfigurableProductOnAdminProductPage] AssertConfigurableProductOnAdminProductPageActionGroup");
		$I->seeInField(".admin__field[data-index=name] input", "API Configurable Product" . msq("ApiConfigurableProduct")); // stepKey: seeNameRequiredAssertConfigurableProductOnAdminProductPage
		$I->seeInField(".admin__field[data-index=sku] input", "api-configurable-product" . msq("ApiConfigurableProduct")); // stepKey: seeSkuRequiredAssertConfigurableProductOnAdminProductPage
		$I->dontSeeInField(".admin__field[data-index=price] input", "123.00"); // stepKey: dontSeePriceRequiredAssertConfigurableProductOnAdminProductPage
		$I->comment("Exiting Action Group [assertConfigurableProductOnAdminProductPage] AssertConfigurableProductOnAdminProductPageActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Assert configurable product in category");
		$I->amOnPage($I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoad
		$I->comment("Entering Action Group [assertConfigurableProductInCategory] StorefrontCheckCategoryConfigurableProductActionGroup");
		$I->seeElement("//main//li//a[contains(text(), 'API Configurable Product" . msq("ApiConfigurableProduct") . "')]"); // stepKey: assertProductNameAssertConfigurableProductInCategory
		$I->see("$1.00", "//main//li[.//a[contains(text(), 'API Configurable Product" . msq("ApiConfigurableProduct") . "')]]//span[@class='price']"); // stepKey: AssertProductPriceAssertConfigurableProductInCategory
		$I->comment("@TODO: MAGETWO-80272 Move to Magento_Checkout");
		$I->moveMouseOver("//main//li[.//a[contains(text(), 'API Configurable Product" . msq("ApiConfigurableProduct") . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAssertConfigurableProductInCategory
		$I->comment("@TODO: MAGETWO-80272 Move to Magento_Checkout");
		$I->seeElement("//main//li[.//a[contains(text(), 'API Configurable Product" . msq("ApiConfigurableProduct") . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartAssertConfigurableProductInCategory
		$I->comment("Exiting Action Group [assertConfigurableProductInCategory] StorefrontCheckCategoryConfigurableProductActionGroup");
		$I->comment("Assert configurable product on product page");
		$I->amOnPage("api-configurable-product" . msq("ApiConfigurableProduct") . ".html"); // stepKey: amOnProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
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
	}
}
