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
 * @Title("MC-13689: Configurable product variation's sku should be based on parent SKU")
 * @Description("Admin should be able to create configurable product with two new options based on parent SKU, without assigned to category and attribute set<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminCreateConfigurableProductBasedOnParentSkuTest.xml<br>")
 * @TestCaseId("MC-13689")
 * @group mtf_migrated
 */
class AdminCreateConfigurableProductBasedOnParentSkuTestCest
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
		$I->comment("Delete configurable product with children products");
		$I->comment("Entering Action Group [deleteProducts] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProducts
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteProducts
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteProductsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProducts
		$I->fillField("input.admin__control-text[name='sku']", "api-configurable-product" . msq("ApiConfigurableProduct")); // stepKey: fillProductSkuFilterDeleteProducts
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProducts
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductsWaitForPageLoad
		$I->see("api-configurable-product" . msq("ApiConfigurableProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProducts
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProducts
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProducts
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProducts
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProducts
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductsWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteProducts
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteProductsWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteProducts
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductsWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteProducts
		$I->comment("Exiting Action Group [deleteProducts] DeleteProductBySkuActionGroup");
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
	public function AdminCreateConfigurableProductBasedOnParentSkuTest(AcceptanceTester $I)
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
		$I->comment("Change product configurations except sku");
		$I->comment("Entering Action Group [changeProductConfigurationsInGridExceptSku] ChangeProductConfigurationsInGridExceptSkuActionGroup");
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Green" . msq("colorConfigurableProductAttribute1") . "')]/ancestor::tr/td[@data-index='name_container']//input", "Green" . msq("colorConfigurableProductAttribute1")); // stepKey: fillFieldNameForFirstAttributeOptionChangeProductConfigurationsInGridExceptSku
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Red" . msq("colorConfigurableProductAttribute2") . "')]/ancestor::tr/td[@data-index='name_container']//input", "Red" . msq("colorConfigurableProductAttribute2")); // stepKey: fillFieldNameForSecondAttributeOptionChangeProductConfigurationsInGridExceptSku
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Green" . msq("colorConfigurableProductAttribute1") . "')]/ancestor::tr/td[@data-index='price_container']//input", "1"); // stepKey: fillFieldPriceForFirstAttributeOptionChangeProductConfigurationsInGridExceptSku
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Red" . msq("colorConfigurableProductAttribute2") . "')]/ancestor::tr/td[@data-index='price_container']//input", "2"); // stepKey: fillFieldPriceForSecondAttributeOptionChangeProductConfigurationsInGridExceptSku
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Green" . msq("colorConfigurableProductAttribute1") . "')]/ancestor::tr/td[@data-index='quantity_container']//input", "1"); // stepKey: fillFieldQuantityForFirstAttributeOptionChangeProductConfigurationsInGridExceptSku
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Red" . msq("colorConfigurableProductAttribute2") . "')]/ancestor::tr/td[@data-index='quantity_container']//input", "10"); // stepKey: fillFieldQuantityForSecondAttributeOptionChangeProductConfigurationsInGridExceptSku
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Green" . msq("colorConfigurableProductAttribute1") . "')]/ancestor::tr/td[@data-index='price_weight']//input", "1"); // stepKey: fillFieldWeightForFirstAttributeOptionChangeProductConfigurationsInGridExceptSku
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Red" . msq("colorConfigurableProductAttribute2") . "')]/ancestor::tr/td[@data-index='price_weight']//input", "1"); // stepKey: fillFieldWeightForSecondAttributeOptionChangeProductConfigurationsInGridExceptSku
		$I->comment("Exiting Action Group [changeProductConfigurationsInGridExceptSku] ChangeProductConfigurationsInGridExceptSkuActionGroup");
		$I->comment("Save product");
		$I->comment("Entering Action Group [saveProduct] SaveConfigurableProductAddToCurrentAttributeSetActionGroup");
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveBtnVisibleSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveBtnVisibleSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: saveProductAgainSaveProduct
		$I->waitForPageLoad(30); // stepKey: saveProductAgainSaveProductWaitForPageLoad
		$I->waitForElementVisible("button[data-index='confirm_button']", 30); // stepKey: waitPopUpVisibleSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitPopUpVisibleSaveProductWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmPopupSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmPopupSaveProductWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSaveProductMessageSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveConfigurableProductAddToCurrentAttributeSetActionGroup");
		$I->comment("Assert child products generated sku in grid");
		$I->comment("Entering Action Group [openProductCatalogPage] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageOpenProductCatalogPage
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadOpenProductCatalogPage
		$I->comment("Exiting Action Group [openProductCatalogPage] AdminProductCatalogPageOpenActionGroup");
		$I->comment("Entering Action Group [filterFirstProductByNameInGrid] FilterProductGridByName2ActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterFirstProductByNameInGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterFirstProductByNameInGridWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterFirstProductByNameInGrid
		$I->fillField("input.admin__control-text[name='name']", "Green" . msq("colorConfigurableProductAttribute1")); // stepKey: fillProductNameFilterFilterFirstProductByNameInGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterFirstProductByNameInGrid
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterFirstProductByNameInGridWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterFirstProductByNameInGrid
		$I->comment("Exiting Action Group [filterFirstProductByNameInGrid] FilterProductGridByName2ActionGroup");
		$I->comment("Entering Action Group [seeFirstProductSkuInGrid] AssertAdminProductGridCellActionGroup");
		$I->see("api-configurable-product" . msq("ApiConfigurableProduct") . "-Green" . msq("colorConfigurableProductAttribute1"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductGridCellWithProvidedValueSeeFirstProductSkuInGrid
		$I->comment("Exiting Action Group [seeFirstProductSkuInGrid] AssertAdminProductGridCellActionGroup");
		$I->comment("Entering Action Group [filterSecondProductByNameInGrid] FilterProductGridByName2ActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterSecondProductByNameInGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterSecondProductByNameInGridWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterSecondProductByNameInGrid
		$I->fillField("input.admin__control-text[name='name']", "Red" . msq("colorConfigurableProductAttribute2")); // stepKey: fillProductNameFilterFilterSecondProductByNameInGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterSecondProductByNameInGrid
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterSecondProductByNameInGridWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterSecondProductByNameInGrid
		$I->comment("Exiting Action Group [filterSecondProductByNameInGrid] FilterProductGridByName2ActionGroup");
		$I->comment("Entering Action Group [seeSecondProductSkuInGrid] AssertAdminProductGridCellActionGroup");
		$I->see("api-configurable-product" . msq("ApiConfigurableProduct") . "-Red" . msq("colorConfigurableProductAttribute2"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductGridCellWithProvidedValueSeeSecondProductSkuInGrid
		$I->comment("Exiting Action Group [seeSecondProductSkuInGrid] AssertAdminProductGridCellActionGroup");
	}
}
