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
 * @Title("MC-17957: Downloadable product type switching on editing to configurable product")
 * @Description("Downloadable product type switching on editing to configurable product<h3>Test files</h3>app/code/Magento/Downloadable/Test/Mftf/Test/AdminProductTypeSwitchingOnEditingTest/AdminDownloadableProductTypeSwitchingToConfigurableProductTest.xml<br>")
 * @TestCaseId("MC-17957")
 * @group catalog
 */
class AdminDownloadableProductTypeSwitchingToConfigurableProductTestCest
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
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
		$I->comment("Create attribute with options");
		$I->comment("Create attribute with options");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOptionOne", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOptionOne
		$I->createEntity("createConfigProductAttributeOptionTwo", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOptionTwo
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Features({"Downloadable"})
	 * @Stories({"Product type switching"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDownloadableProductTypeSwitchingToConfigurableProductTest(AcceptanceTester $I)
	{
		$I->comment("Add configurations to product");
		$I->comment("Add configurations to product");
		$I->comment("Entering Action Group [gotToSimpleProductPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductGotToSimpleProductPage
		$I->comment("Exiting Action Group [gotToSimpleProductPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForSimpleProductPageLoad
		$I->click("div[data-index='downloadable']"); // stepKey: openDownloadableSection
		$I->waitForPageLoad(30); // stepKey: openDownloadableSectionWaitForPageLoad
		$I->uncheckOption("input[name='is_downloadable']"); // stepKey: checkOptionIsDownloadable
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightForProduct
		$I->comment("Entering Action Group [saveDownloadableProductForm] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveDownloadableProductForm
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveDownloadableProductForm
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveDownloadableProductFormWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveDownloadableProductForm
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveDownloadableProductFormWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveDownloadableProductForm
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveDownloadableProductForm
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveDownloadableProductForm
		$I->comment("Exiting Action Group [saveDownloadableProductForm] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [setupConfigurations] GenerateConfigurationsByAttributeCodeActionGroup");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurationsSetupConfigurations
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsSetupConfigurationsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersSetupConfigurations
		$I->fillField(".admin__control-text[name='attribute_code']", $I->retrieveEntityField('createConfigProductAttribute', 'attribute_code', 'test')); // stepKey: fillFilterAttributeCodeFieldSetupConfigurations
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonSetupConfigurations
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSetupConfigurationsWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxSetupConfigurations
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1SetupConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1SetupConfigurationsWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllSetupConfigurations
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2SetupConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2SetupConfigurationsWaitForPageLoad
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuSetupConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuSetupConfigurationsWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "99"); // stepKey: enterAttributeQuantitySetupConfigurations
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3SetupConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3SetupConfigurationsWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4SetupConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4SetupConfigurationsWaitForPageLoad
		$I->comment("Exiting Action Group [setupConfigurations] GenerateConfigurationsByAttributeCodeActionGroup");
		$I->comment("Entering Action Group [saveConfigProductForm] SaveConfiguredProductActionGroup");
		$I->click("#save-button"); // stepKey: clickOnSaveButton2SaveConfigProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButton2SaveConfigProductFormWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmInPopupSaveConfigProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupSaveConfigProductFormWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessageSaveConfigProductForm
		$I->comment("Exiting Action Group [saveConfigProductForm] SaveConfiguredProductActionGroup");
		$I->comment("Assert configurable product on Admin product page grid");
		$I->comment("Assert configurable product in Admin product page grid");
		$I->comment("Entering Action Group [goToCatalogProductPage] AdminOpenCatalogProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openCatalogProductPageGoToCatalogProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCatalogProductPage
		$I->comment("Exiting Action Group [goToCatalogProductPage] AdminOpenCatalogProductPageActionGroup");
		$I->comment("Entering Action Group [filterProductGridBySku] FilterProductGridBySku2ActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductGridBySku
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductGridBySkuWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGridBySku
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGridBySku
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridBySku
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridBySkuWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridBySku
		$I->comment("Exiting Action Group [filterProductGridBySku] FilterProductGridBySku2ActionGroup");
		$I->seeElement("//div[@data-role='grid-wrapper']//table[contains(@class, 'data-grid')]//td[count(../../..//th[./*[.='Type']]/preceding-sibling::th) + 1][./*[.='Configurable Product']]/../td[contains(.,'" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]"); // stepKey: seeConfigurableProductInGrid
		$I->seeElement("//div[@data-role='grid-wrapper']//table[contains(@class, 'data-grid')]//td[count(../../..//th[./*[.='Type']]/preceding-sibling::th) + 1][./*[.='Simple Product']]/../td[contains(.,'" . $I->retrieveEntityField('createProduct', 'name', 'test') . "-option1')]"); // stepKey: seeSimpleProduct1NameInGrid
		$I->seeElement("//div[@data-role='grid-wrapper']//table[contains(@class, 'data-grid')]//td[count(../../..//th[./*[.='Type']]/preceding-sibling::th) + 1][./*[.='Simple Product']]/../td[contains(.,'" . $I->retrieveEntityField('createProduct', 'name', 'test') . "-option2')]"); // stepKey: seeSimpleProduct2NameInGrid
		$I->comment("Assert configurable product on storefront");
		$I->comment("Assert configurable product on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoad
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStock
		$I->click("#product-options-wrapper .super-attribute-select"); // stepKey: clickAttributeDropDown
		$I->see("option1"); // stepKey: verifyOption1Exists
		$I->see("option2"); // stepKey: verifyOption2Exists
		$I->comment("Open Dropdown and select downloadable product option");
	}
}
