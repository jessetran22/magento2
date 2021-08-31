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
 * @Title("MAGETWO-93059: Correct error message and redirect with invalid file option")
 * @Description("Configurable product has file custom option. When adding to cart with an invalid filetype, the correct error message is shown, and options remain selected.<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/StorefrontConfigurableProductWithFileCustomOptionTest.xml<br>")
 * @TestCaseId("MAGETWO-93059")
 * @group ConfigurableProduct
 */
class StorefrontConfigurableProductWithFileCustomOptionTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageOpenProductIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadOpenProductIndexPage
		$I->comment("Exiting Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [clearGridFiltersConfigurable] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopClearGridFiltersConfigurable
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersClearGridFiltersConfigurable
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetClearGridFiltersConfigurable
		$I->comment("Exiting Action Group [clearGridFiltersConfigurable] AdminGridFilterResetActionGroup");
		$I->comment("Entering Action Group [addSkuFilterConfigurable] AdminGridFilterFillInputFieldActionGroup");
		$I->conditionalClick("//div[@class='admin__data-grid-header'][(not(ancestor::*[@class='sticky-header']) and not(contains(@style,'visibility: hidden'))) or (ancestor::*[@class='sticky-header' and not(contains(@style,'display: none'))])]//button[@data-action='grid-filter-expand']", "[data-part='filter-form']", false); // stepKey: openFiltersFormIfNecessaryAddSkuFilterConfigurable
		$I->waitForElementVisible("[data-part='filter-form']", 30); // stepKey: waitForFormVisibleAddSkuFilterConfigurable
		$I->fillField("//*[@data-part='filter-form']//input[@name='sku']", "configurable" . msq("BaseConfigurableProduct")); // stepKey: fillFilterInputFieldAddSkuFilterConfigurable
		$I->comment("Exiting Action Group [addSkuFilterConfigurable] AdminGridFilterFillInputFieldActionGroup");
		$I->comment("Entering Action Group [addTypeFilterConfigurable] AdminGridFilterFillSelectFieldActionGroup");
		$I->selectOption("//*[@data-part='filter-form']//select[@name='type_id']", "Configurable Product"); // stepKey: selectOptionAddTypeFilterConfigurable
		$I->comment("Exiting Action Group [addTypeFilterConfigurable] AdminGridFilterFillSelectFieldActionGroup");
		$I->comment("Entering Action Group [applyGridFilterConfigurable] AdminClickSearchInGridActionGroup");
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchApplyGridFilterConfigurable
		$I->waitForPageLoad(30); // stepKey: clickSearchApplyGridFilterConfigurableWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultApplyGridFilterConfigurable
		$I->comment("Exiting Action Group [applyGridFilterConfigurable] AdminClickSearchInGridActionGroup");
		$I->comment("Entering Action Group [deleteConfigurableProduct] DeleteProductsIfTheyExistActionGroup");
		$I->conditionalClick("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle", "table.data-grid tr.data-row:first-of-type", true); // stepKey: openMulticheckDropdownDeleteConfigurableProduct
		$I->conditionalClick("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']", "table.data-grid tr.data-row:first-of-type", true); // stepKey: selectAllProductInFilteredGridDeleteConfigurableProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteConfigurableProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteConfigurableProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm button.action-accept", 30); // stepKey: waitForModalPopUpDeleteConfigurableProduct
		$I->waitForPageLoad(60); // stepKey: waitForModalPopUpDeleteConfigurableProductWaitForPageLoad
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteConfigurableProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteConfigurableProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadDeleteConfigurableProduct
		$I->comment("Exiting Action Group [deleteConfigurableProduct] DeleteProductsIfTheyExistActionGroup");
		$I->comment("Entering Action Group [clearGridFiltersVirtual] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopClearGridFiltersVirtual
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersClearGridFiltersVirtual
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetClearGridFiltersVirtual
		$I->comment("Exiting Action Group [clearGridFiltersVirtual] AdminGridFilterResetActionGroup");
		$I->comment("Entering Action Group [addSkuFilterVirtual] AdminGridFilterFillInputFieldActionGroup");
		$I->conditionalClick("//div[@class='admin__data-grid-header'][(not(ancestor::*[@class='sticky-header']) and not(contains(@style,'visibility: hidden'))) or (ancestor::*[@class='sticky-header' and not(contains(@style,'display: none'))])]//button[@data-action='grid-filter-expand']", "[data-part='filter-form']", false); // stepKey: openFiltersFormIfNecessaryAddSkuFilterVirtual
		$I->waitForElementVisible("[data-part='filter-form']", 30); // stepKey: waitForFormVisibleAddSkuFilterVirtual
		$I->fillField("//*[@data-part='filter-form']//input[@name='sku']", "configurable" . msq("BaseConfigurableProduct")); // stepKey: fillFilterInputFieldAddSkuFilterVirtual
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
		$I->comment("Entering Action Group [resetProductGrid] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetProductGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetProductGridWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetProductGrid
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetProductGrid
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetProductGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetProductGrid
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetProductGrid
		$I->comment("Exiting Action Group [resetProductGrid] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Stories({"Add configurable product to cart"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontConfigurableProductWithFileCustomOptionTest(AcceptanceTester $I)
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
		$I->comment("Create a configurable product via the UI");
		$I->comment("Entering Action Group [createProduct] CreateConfigurableProductActionGroup");
		$I->comment("fill in basic configurable product values");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: amOnProductGridPageCreateProduct
		$I->waitForPageLoad(30); // stepKey: wait1CreateProduct
		$I->click(".action-toggle.primary.add"); // stepKey: clickOnAddProductToggleCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnAddProductToggleCreateProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-configurable']"); // stepKey: clickOnAddConfigurableProductCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnAddConfigurableProductCreateProductWaitForPageLoad
		$I->fillField(".admin__field[data-index=name] input", "configurable" . msq("BaseConfigurableProduct")); // stepKey: fillNameCreateProduct
		$I->fillField(".admin__field[data-index=sku] input", "configurable" . msq("BaseConfigurableProduct")); // stepKey: fillSKUCreateProduct
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillPriceCreateProduct
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillQuantityCreateProduct
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'test')]); // stepKey: fillCategoryCreateProduct
		$I->waitForPageLoad(30); // stepKey: fillCategoryCreateProductWaitForPageLoad
		$I->selectOption("//select[@name='product[visibility]']", "4"); // stepKey: fillVisibilityCreateProduct
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSectionCreateProduct
		$I->waitForPageLoad(30); // stepKey: openSeoSectionCreateProductWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", "configurable" . msq("BaseConfigurableProduct")); // stepKey: fillUrlKeyCreateProduct
		$I->comment("create configurations for colors the product is available in");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickOnCreateConfigurationsCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnCreateConfigurationsCreateProductWaitForPageLoad
		$I->click(".select-attributes-actions button[title='Create New Attribute']"); // stepKey: clickOnNewAttributeCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNewAttributeCreateProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForIFrameCreateProduct
		$I->switchToIFrame("create_new_attribute_container"); // stepKey: switchToNewAttributeIFrameCreateProduct
		$I->fillField("input[name='frontend_label[0]']", "Color" . msq("colorProductAttribute")); // stepKey: fillDefaultLabelCreateProduct
		$I->click("#save"); // stepKey: clickOnNewAttributePanelCreateProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveAttributeCreateProduct
		$I->switchToIFrame(); // stepKey: switchOutOfIFrameCreateProduct
		$I->waitForPageLoad(30); // stepKey: waitForFiltersCreateProduct
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickOnFiltersCreateProduct
		$I->fillField(".admin__control-text[name='attribute_code']", "Color" . msq("colorProductAttribute")); // stepKey: fillFilterAttributeCodeFieldCreateProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonCreateProductWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxCreateProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1CreateProductWaitForPageLoad
		$I->waitForElementVisible(".action-create-new", 30); // stepKey: waitCreateNewValueAppearsCreateProduct
		$I->waitForPageLoad(30); // stepKey: waitCreateNewValueAppearsCreateProductWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateNewValue1CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnCreateNewValue1CreateProductWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "White" . msq("colorProductAttribute1")); // stepKey: fillFieldForNewAttribute1CreateProduct
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveNewAttribute1CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnSaveNewAttribute1CreateProductWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateNewValue2CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnCreateNewValue2CreateProductWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "Red" . msq("colorProductAttribute2")); // stepKey: fillFieldForNewAttribute2CreateProduct
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveNewAttribute2CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnSaveNewAttribute2CreateProductWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateNewValue3CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnCreateNewValue3CreateProductWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "Blue" . msq("colorProductAttribute3")); // stepKey: fillFieldForNewAttribute3CreateProduct
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveNewAttribute3CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnSaveNewAttribute3CreateProductWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllCreateProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2CreateProductWaitForPageLoad
		$I->click(".admin__field-label[for='apply-unique-prices-radio']"); // stepKey: clickOnApplyUniquePricesByAttributeToEachSkuCreateProduct
		$I->selectOption("#select-each-price", "Color" . msq("colorProductAttribute")); // stepKey: selectAttributesCreateProduct
		$I->waitForPageLoad(30); // stepKey: selectAttributesCreateProductWaitForPageLoad
		$I->fillField("#apply-single-price-input-0", "1.00"); // stepKey: fillAttributePrice1CreateProduct
		$I->fillField("#apply-single-price-input-1", "2.00"); // stepKey: fillAttributePrice2CreateProduct
		$I->fillField("#apply-single-price-input-2", "3.00"); // stepKey: fillAttributePrice3CreateProduct
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuCreateProductWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "1"); // stepKey: enterAttributeQuantityCreateProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3CreateProductWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4CreateProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButton2CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButton2CreateProductWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmInPopupCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupCreateProductWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessageCreateProduct
		$I->seeInTitle("configurable" . msq("BaseConfigurableProduct")); // stepKey: seeProductNameInTitleCreateProduct
		$I->comment("Exiting Action Group [createProduct] CreateConfigurableProductActionGroup");
		$I->comment("Add custom option to configurable product");
		$I->comment("Entering Action Group [addCustomOptionToProduct] AddProductCustomOptionFileActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "button[data-index='button_add']", false); // stepKey: openCustomOptionSectionAddCustomOptionToProduct
		$I->waitForPageLoad(30); // stepKey: openCustomOptionSectionAddCustomOptionToProductWaitForPageLoad
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionAddCustomOptionToProduct
		$I->waitForPageLoad(30); // stepKey: clickAddOptionAddCustomOptionToProductWaitForPageLoad
		$I->waitForElementVisible("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, '_required')]//input", 30); // stepKey: waitForOptionAddCustomOptionToProduct
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, '_required')]//input", "OptionFile"); // stepKey: fillTitleAddCustomOptionToProduct
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__action-multiselect-text')]"); // stepKey: openTypeSelectAddCustomOptionToProduct
		$I->click("//*[@data-index='custom_options']//label[text()='File'][ancestor::*[contains(@class, '_active')]]"); // stepKey: selectTypeFileAddCustomOptionToProduct
		$I->waitForElementVisible("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'OptionFile')]/ancestor::tr//*[@data-index='price']//input", 30); // stepKey: waitForElementsAddCustomOptionToProduct
		$I->fillField("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'OptionFile')]/ancestor::tr//*[@data-index='price']//input", "9.99"); // stepKey: fillPriceAddCustomOptionToProduct
		$I->selectOption("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'OptionFile')]/ancestor::tr//*[@data-index='price_type']//select", "fixed"); // stepKey: selectPriceTypeAddCustomOptionToProduct
		$I->fillField("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'OptionFile')]/ancestor::tr//*[@data-index='file_extension']//input", "png, jpg, gif"); // stepKey: fillCompatibleExtensionsAddCustomOptionToProduct
		$I->comment("Exiting Action Group [addCustomOptionToProduct] AddProductCustomOptionFileActionGroup");
		$I->comment("Entering Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: saveProductSaveProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingSaveProduct
		$I->comment("Exiting Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->comment("Go to storefront");
		$I->comment("Entering Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage
		$I->comment("Exiting Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->click("//a[contains(@class,'level-top')]/span[contains(text(),'" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]"); // stepKey: goToCategoryStorefront
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoad
		$I->see($I->retrieveEntityField('createCategory', 'name', 'test'), "#page-title-heading span"); // stepKey: seeOnCategoryPage
		$I->comment("Add configurable product to cart");
		$I->moveMouseOver("//main//li//a[contains(text(), 'configurable" . msq("BaseConfigurableProduct") . "')]"); // stepKey: hoverProductInGrid
		$I->click("//main//li[.//a[contains(text(), 'configurable" . msq("BaseConfigurableProduct") . "')]]//button[contains(@class, 'tocart')]"); // stepKey: tryAddToCartFromCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForRedirectToProductPage
		$I->seeInCurrentUrl("/configurable" . msq("BaseConfigurableProduct") . ".html"); // stepKey: seeOnProductPage
		$I->selectOption("#product-options-wrapper .super-attribute-select", "Red" . msq("colorProductAttribute2")); // stepKey: selectColor
		$I->comment("Try invalid file");
		$I->attachFile("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionFile')]/../div[@class='control']//input[@type='file']", "lorem_ipsum.docx"); // stepKey: attachInvalidFile
		$I->click("button.action.tocart.primary"); // stepKey: addToCartInvalidFile
		$I->waitForPageLoad(30); // stepKey: addToCartInvalidFileWaitForPageLoad
		$I->waitForElementVisible(".page.messages [role=alert]", 30); // stepKey: waitForErrorMessageInvalidFile
		$I->see("The file 'lorem_ipsum.docx' for 'OptionFile' has an invalid extension.", ".page.messages"); // stepKey: seeMessageInvalidFile
		$I->waitForPageLoad(30); // stepKey: seeMessageInvalidFileWaitForPageLoad
		$I->comment("Option remains selected");
		$I->seeOptionIsSelected("#product-options-wrapper .super-attribute-select", "Red" . msq("colorProductAttribute2")); // stepKey: seeOptionRemainSelected
		$I->comment("Try valid file");
		$I->attachFile("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionFile')]/../div[@class='control']//input[@type='file']", "magento-logo.png"); // stepKey: attachValidFile
		$I->see("$11.99", "div.price-box.price-final_price"); // stepKey: seePriceUpdated
		$I->click("button.action.tocart.primary"); // stepKey: addToCartValidFile
		$I->waitForPageLoad(30); // stepKey: addToCartValidFileWaitForPageLoad
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessage
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageWaitForPageLoad
		$I->see("You added configurable" . msq("BaseConfigurableProduct") . " to your shopping cart.", ".page.messages"); // stepKey: seeSuccessMessage
		$I->waitForPageLoad(30); // stepKey: seeSuccessMessageWaitForPageLoad
		$I->comment("Check item in cart");
		$I->comment("Entering Action Group [goToCart] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCart
		$I->comment("Exiting Action Group [goToCart] StorefrontCartPageOpenActionGroup");
		$I->seeElement("//main//table[@id='shopping-cart-table']//tbody//tr//strong[contains(@class, 'product-item-name')]//a[contains(text(), 'configurable" . msq("BaseConfigurableProduct") . "')]"); // stepKey: seeProductInCart
		$I->see("Red" . msq("colorProductAttribute2"), "//main//table[@id='shopping-cart-table']//tbody//tr[.//strong[contains(@class, 'product-item-name')]//a[contains(text(), 'configurable" . msq("BaseConfigurableProduct") . "')]]//dl[@class='item-options']//dt[.='Color" . msq("colorProductAttribute") . "']/following-sibling::dd[1]"); // stepKey: seeSelectedOption
		$I->see("magento-logo.png", "//main//table[@id='shopping-cart-table']//tbody//tr[.//strong[contains(@class, 'product-item-name')]//a[contains(text(), 'configurable" . msq("BaseConfigurableProduct") . "')]]//dl[@class='item-options']//dt[.='OptionFile']/following-sibling::dd[1]"); // stepKey: seeCorrectOptionFile
		$I->comment("Delete cart item");
		$I->click("//table[@id='shopping-cart-table']//tbody//tr[contains(@class,'item-actions')]//a[contains(@class,'action-delete')]"); // stepKey: deleteCartItem
	}
}
