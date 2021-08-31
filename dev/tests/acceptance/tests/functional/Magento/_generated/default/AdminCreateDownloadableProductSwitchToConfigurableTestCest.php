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
 * @Title("MAGETWO-29398: Admin should be able to switch a new product from downloadable to configurable")
 * @Description("After selecting a downloadable product when adding Admin should be switch to configurable implicitly<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminCreateAndSwitchProductType/AdminCreateDownloadableProductSwitchToConfigurableTest.xml<br>")
 * @TestCaseId("MAGETWO-29398")
 * @group catalog
 * @group mtf_migrated
 */
class AdminCreateDownloadableProductSwitchToConfigurableTestCest
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
		$I->createEntity("createPreReqCategory", "hook", "_defaultCategory", [], []); // stepKey: createPreReqCategory
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToProductCatalogPage] AdminOpenCatalogProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openCatalogProductPageGoToProductCatalogPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToProductCatalogPage
		$I->comment("Exiting Action Group [goToProductCatalogPage] AdminOpenCatalogProductPageActionGroup");
		$I->comment("Entering Action Group [deleteConfigurableProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteConfigurableProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteConfigurableProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteConfigurableProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteConfigurableProduct
		$I->fillField("input.admin__control-text[name='sku']", "testSku" . msq("_defaultProduct")); // stepKey: fillProductSkuFilterDeleteConfigurableProduct
		$I->fillField("input.admin__control-text[name='name']", "testProductName" . msq("_defaultProduct")); // stepKey: fillProductNameFilterDeleteConfigurableProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteConfigurableProductWaitForPageLoad
		$I->see("testSku" . msq("_defaultProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteConfigurableProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteConfigurableProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteConfigurableProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteConfigurableProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteConfigurableProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteConfigurableProduct
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteConfigurableProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteConfigurableProductWaitForPageLoad
		$I->comment("Exiting Action Group [deleteConfigurableProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("Entering Action Group [resetSearch] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetSearch
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetSearchWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetSearch
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetSearch
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetSearchWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetSearch
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetSearch
		$I->comment("Exiting Action Group [resetSearch] ResetProductGridToDefaultViewActionGroup");
		$I->deleteEntity("createPreReqCategory", "hook"); // stepKey: deletePreReqCategory
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteAttribute
		$runCron = $I->magentoCLI("cron:run --group=index", 60); // stepKey: runCron
		$I->comment($runCron);
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
	 * @Stories({"Product Type Switching"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateDownloadableProductSwitchToConfigurableTest(AcceptanceTester $I)
	{
		$I->comment("Create configurable product from downloadable product page");
		$I->comment("Create configurable product");
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->comment("Open Dropdown and select downloadable product option");
		$I->comment("Selecting Product from the Add Product Dropdown");
		$I->comment("Entering Action Group [openProductFillForm] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("actionGroup:GoToSpecifiedCreateProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexOpenProductFillForm
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownOpenProductFillForm
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownOpenProductFillFormWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-downloadable']"); // stepKey: clickAddProductOpenProductFillForm
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadOpenProductFillForm
		$I->comment("Exiting Action Group [openProductFillForm] GoToSpecifiedCreateProductPageActionGroup");
		$I->scrollTo("div[data-index='downloadable']"); // stepKey: scrollToDownloadableInfo
		$I->waitForPageLoad(30); // stepKey: scrollToDownloadableInfoWaitForPageLoad
		$I->uncheckOption("input[name='is_downloadable']"); // stepKey: checkIsDownloadable
		$I->comment("Fill form for Downloadable Product Type");
		$I->comment("Filling Product Form");
		$I->comment("Entering Action Group [fillProductForm] FillMainProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillProductForm
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillProductNameFillProductForm
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillProductSkuFillProductForm
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillProductForm
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillProductForm
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillProductForm
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillProductFormWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillProductForm
		$I->fillField(".admin__field[data-index=weight] input", "1"); // stepKey: fillProductWeightFillProductForm
		$I->comment("Exiting Action Group [fillProductForm] FillMainProductFormActionGroup");
		$I->comment("Entering Action Group [setProductUrl] SetProductUrlKeyActionGroup");
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSectionSetProductUrl
		$I->waitForPageLoad(30); // stepKey: openSeoSectionSetProductUrlWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", "testproductname" . msq("_defaultProduct")); // stepKey: fillUrlKeySetProductUrl
		$I->comment("Exiting Action Group [setProductUrl] SetProductUrlKeyActionGroup");
		$I->comment("Adding Configuration to Product");
		$I->comment("Entering Action Group [createConfiguration] GenerateConfigurationsByAttributeCodeActionGroup");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurationsCreateConfiguration
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsCreateConfigurationWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersCreateConfiguration
		$I->fillField(".admin__control-text[name='attribute_code']", $I->retrieveEntityField('createConfigProductAttribute', 'attribute_code', 'test')); // stepKey: fillFilterAttributeCodeFieldCreateConfiguration
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonCreateConfiguration
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonCreateConfigurationWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxCreateConfiguration
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1CreateConfiguration
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1CreateConfigurationWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllCreateConfiguration
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2CreateConfiguration
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2CreateConfigurationWaitForPageLoad
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuCreateConfiguration
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuCreateConfigurationWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "99"); // stepKey: enterAttributeQuantityCreateConfiguration
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3CreateConfiguration
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3CreateConfigurationWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4CreateConfiguration
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4CreateConfigurationWaitForPageLoad
		$I->comment("Exiting Action Group [createConfiguration] GenerateConfigurationsByAttributeCodeActionGroup");
		$I->comment("Entering Action Group [saveProductForm] SaveConfiguredProductActionGroup");
		$I->click("#save-button"); // stepKey: clickOnSaveButton2SaveProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButton2SaveProductFormWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmInPopupSaveProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupSaveProductFormWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessageSaveProductForm
		$I->comment("Exiting Action Group [saveProductForm] SaveConfiguredProductActionGroup");
		$I->comment("Check that product was added with implicit type change");
		$I->comment("Verify Product Type Assigned Correctly");
		$I->comment("Entering Action Group [goToProductCatalogPage] AdminOpenCatalogProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openCatalogProductPageGoToProductCatalogPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToProductCatalogPage
		$I->comment("Exiting Action Group [goToProductCatalogPage] AdminOpenCatalogProductPageActionGroup");
		$I->comment("Entering Action Group [resetSearch] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetSearch
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetSearchWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetSearch
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetSearch
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetSearchWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetSearch
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetSearch
		$I->comment("Exiting Action Group [resetSearch] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [searchForProduct] FilterProductGridByNameActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchForProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchForProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersSearchForProduct
		$I->fillField("input.admin__control-text[name='name']", "testProductName" . msq("_defaultProduct")); // stepKey: fillProductNameFilterSearchForProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersSearchForProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersSearchForProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadSearchForProduct
		$I->comment("Exiting Action Group [searchForProduct] FilterProductGridByNameActionGroup");
		$I->comment("Entering Action Group [seeProductTypeInGrid] AssertAdminProductGridCellActionGroup");
		$I->see("Configurable Product", "//tr[2]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Type']/preceding-sibling::th) +1 ]"); // stepKey: seeProductGridCellWithProvidedValueSeeProductTypeInGrid
		$I->comment("Exiting Action Group [seeProductTypeInGrid] AssertAdminProductGridCellActionGroup");
		$I->comment("Entering Action Group [assertProductInStorefrontProductPage] AssertProductInStorefrontProductPageActionGroup");
		$I->comment("Go to storefront product page, assert product name, sku and price");
		$I->amOnPage("testproductname" . msq("_defaultProduct") . ".html"); // stepKey: navigateToProductPageAssertProductInStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssertProductInStorefrontProductPage
		$I->seeInTitle("testProductName" . msq("_defaultProduct")); // stepKey: assertProductNameTitleAssertProductInStorefrontProductPage
		$I->see("testProductName" . msq("_defaultProduct"), ".base"); // stepKey: assertProductNameAssertProductInStorefrontProductPage
		$I->see("123.00", "div.price-box.price-final_price"); // stepKey: assertProductPriceAssertProductInStorefrontProductPage
		$I->see("testSku" . msq("_defaultProduct"), ".product.attribute.sku>.value"); // stepKey: assertProductSkuAssertProductInStorefrontProductPage
		$I->comment("Exiting Action Group [assertProductInStorefrontProductPage] AssertProductInStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [verifyConfigurableOption] VerifyOptionInProductStorefrontActionGroup");
		$I->seeElement("//div[@class='fieldset']//div[//span[text()='" . $I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test') . "']]//option[text()='" . $I->retrieveEntityField('createConfigProductAttributeOption1', 'option[store_labels][1][label]', 'test') . "']"); // stepKey: verifyOptionExistsVerifyConfigurableOption
		$I->comment("Exiting Action Group [verifyConfigurableOption] VerifyOptionInProductStorefrontActionGroup");
	}
}
