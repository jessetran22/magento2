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
 * @Title("MC-17953: Virtual product type switching on editing to configurable product")
 * @Description("Virtual product type switching on editing to configurable product<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminProductTypeSwitchingOnEditingTest/AdminVirtualProductTypeSwitchingToConfigurableProductTest.xml<br>")
 * @TestCaseId("MC-17953")
 * @group catalog
 */
class AdminVirtualProductTypeSwitchingToConfigurableProductTestCest
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
		$I->comment("Create product");
		$I->comment("Create product");
		$I->createEntity("createProduct", "hook", "VirtualProduct", [], []); // stepKey: createProduct
		$I->comment("Create attribute with options");
		$I->comment("Create attribute with options");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOptionOne", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOptionOne
		$I->createEntity("createConfigProductAttributeOptionTwo", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOptionTwo
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete product");
		$I->comment("Delete product");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteAttribute
		$I->comment("Entering Action Group [deleteAllDuplicateProducts] DeleteAllDuplicateProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteAllDuplicateProducts
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteAllDuplicateProducts
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteAllDuplicateProducts
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteAllDuplicateProductsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteAllDuplicateProducts
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createProduct', 'sku', 'hook')); // stepKey: fillProductSkuFilterDeleteAllDuplicateProducts
		$I->fillField("input.admin__control-text[name='name']", $I->retrieveEntityField('createProduct', 'name', 'hook')); // stepKey: fillProductNameFilterDeleteAllDuplicateProducts
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteAllDuplicateProducts
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteAllDuplicateProductsWaitForPageLoad
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteAllDuplicateProducts
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteAllDuplicateProducts
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteAllDuplicateProducts
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteAllDuplicateProductsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteAllDuplicateProducts
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteAllDuplicateProductsWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteAllDuplicateProducts
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteAllDuplicateProducts
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteAllDuplicateProductsWaitForPageLoad
		$I->comment("Exiting Action Group [deleteAllDuplicateProducts] DeleteAllDuplicateProductUsingProductGridActionGroup");
		$I->comment("Entering Action Group [clearProductFilters] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearProductFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearProductFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearProductFilters
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearProductFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductFilters] AdminClearFiltersActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Stories({"Product type switching"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminVirtualProductTypeSwitchingToConfigurableProductTest(AcceptanceTester $I)
	{
		$I->comment("Add configurations to product");
		$I->comment("Add configurations to product");
		$I->comment("Entering Action Group [gotToConfigProductPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductGotToConfigProductPage
		$I->comment("Exiting Action Group [gotToConfigProductPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForConfigurableProductPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightForConfigurableProduct
		$I->comment("Entering Action Group [setupConfigurationsForProduct] GenerateConfigurationsByAttributeCodeActionGroup");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurationsSetupConfigurationsForProduct
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsSetupConfigurationsForProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersSetupConfigurationsForProduct
		$I->fillField(".admin__control-text[name='attribute_code']", $I->retrieveEntityField('createConfigProductAttribute', 'attribute_code', 'test')); // stepKey: fillFilterAttributeCodeFieldSetupConfigurationsForProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonSetupConfigurationsForProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSetupConfigurationsForProductWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxSetupConfigurationsForProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1SetupConfigurationsForProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1SetupConfigurationsForProductWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllSetupConfigurationsForProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2SetupConfigurationsForProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2SetupConfigurationsForProductWaitForPageLoad
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuSetupConfigurationsForProduct
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuSetupConfigurationsForProductWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "99"); // stepKey: enterAttributeQuantitySetupConfigurationsForProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3SetupConfigurationsForProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3SetupConfigurationsForProductWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4SetupConfigurationsForProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4SetupConfigurationsForProductWaitForPageLoad
		$I->comment("Exiting Action Group [setupConfigurationsForProduct] GenerateConfigurationsByAttributeCodeActionGroup");
		$I->comment("Entering Action Group [saveNewConfigurableProductForm] SaveConfiguredProductActionGroup");
		$I->click("#save-button"); // stepKey: clickOnSaveButton2SaveNewConfigurableProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButton2SaveNewConfigurableProductFormWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmInPopupSaveNewConfigurableProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupSaveNewConfigurableProductFormWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessageSaveNewConfigurableProductForm
		$I->comment("Exiting Action Group [saveNewConfigurableProductForm] SaveConfiguredProductActionGroup");
		$I->comment("Assert configurable product on Admin product page grid");
		$I->comment("Assert configurable product in Admin product page grid");
		$I->comment("Entering Action Group [goToCatalogProductPageForConfigurable] AdminOpenCatalogProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openCatalogProductPageGoToCatalogProductPageForConfigurable
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCatalogProductPageForConfigurable
		$I->comment("Exiting Action Group [goToCatalogProductPageForConfigurable] AdminOpenCatalogProductPageActionGroup");
		$I->comment("Entering Action Group [filterProductGridBySkuForConfigurable] FilterProductGridBySku2ActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductGridBySkuForConfigurable
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductGridBySkuForConfigurableWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGridBySkuForConfigurable
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGridBySkuForConfigurable
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridBySkuForConfigurable
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridBySkuForConfigurableWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridBySkuForConfigurable
		$I->comment("Exiting Action Group [filterProductGridBySkuForConfigurable] FilterProductGridBySku2ActionGroup");
		$I->comment("Entering Action Group [seeConfigurableProductNameInGrid] AssertAdminProductGridCellActionGroup");
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Name']/preceding-sibling::th) +1 ]"); // stepKey: seeProductGridCellWithProvidedValueSeeConfigurableProductNameInGrid
		$I->comment("Exiting Action Group [seeConfigurableProductNameInGrid] AssertAdminProductGridCellActionGroup");
		$I->comment("Entering Action Group [seeConfigurableProductTypeInGrid] AssertAdminProductGridCellActionGroup");
		$I->see("Configurable Product", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Type']/preceding-sibling::th) +1 ]"); // stepKey: seeProductGridCellWithProvidedValueSeeConfigurableProductTypeInGrid
		$I->comment("Exiting Action Group [seeConfigurableProductTypeInGrid] AssertAdminProductGridCellActionGroup");
		$I->comment("Entering Action Group [seeConfigurableProductNameInGrid1] AssertAdminProductGridCellActionGroup");
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test') . "-option1", "//tr[2]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Name']/preceding-sibling::th) +1 ]"); // stepKey: seeProductGridCellWithProvidedValueSeeConfigurableProductNameInGrid1
		$I->comment("Exiting Action Group [seeConfigurableProductNameInGrid1] AssertAdminProductGridCellActionGroup");
		$I->comment("Entering Action Group [seeConfigurableProductNameInGrid2] AssertAdminProductGridCellActionGroup");
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test') . "-option2", "//tr[3]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Name']/preceding-sibling::th) +1 ]"); // stepKey: seeProductGridCellWithProvidedValueSeeConfigurableProductNameInGrid2
		$I->comment("Exiting Action Group [seeConfigurableProductNameInGrid2] AssertAdminProductGridCellActionGroup");
		$I->comment("Entering Action Group [clearConfigurableProductFilters] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearConfigurableProductFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearConfigurableProductFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearConfigurableProductFilters
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearConfigurableProductFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearConfigurableProductFilters] AdminClearFiltersActionGroup");
		$I->comment("Assert configurable product on storefront");
		$I->comment("Assert configurable product on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openConfigurableProductPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontConfigurableProductPageLoad
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertConfigurableProductInStock
		$I->click("#product-options-wrapper .super-attribute-select"); // stepKey: clickConfigurableAttributeDropDown
		$I->see("option1"); // stepKey: verifyConfigurableProductOption1Exists
		$I->see("option2"); // stepKey: verifyConfigurableProductOption2Exists
	}
}
