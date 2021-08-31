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
 * @Title("MC-6192: Checking results of color and other filters")
 * @Description("Checking results of filters: color and other filters<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminCheckResultsOfColorAndOtherFiltersTest.xml<br>app/code/Magento/LayeredNavigation/Test/Mftf/Test/AdminCheckResultsOfColorAndOtherFiltersTest.xml<br>")
 * @TestCaseId("MC-6192")
 * @group ConfigurableProduct
 */
class AdminCheckResultsOfColorAndOtherFiltersTestCest
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
		$I->comment("Create default category with subcategory");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSubcategory", "hook", "SubCategoryWithParent", ["createCategory"], []); // stepKey: createSubcategory
		$I->comment("Create three configurable product");
		$I->createEntity("createFirstConfigurableProduct", "hook", "ConfigurableProductWithAttributeSet", ["createCategory"], []); // stepKey: createFirstConfigurableProduct
		$I->createEntity("createSecondConfigurableProduct", "hook", "ConfigurableProductWithAttributeSet", ["createCategory"], []); // stepKey: createSecondConfigurableProduct
		$I->createEntity("createThirdConfigurableProduct", "hook", "ConfigurableProductWithAttributeSet", ["createCategory"], []); // stepKey: createThirdConfigurableProduct
		$I->createEntity("createSimpleProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$I->comment("Add first attribute with options");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->createEntity("createConfigProductAttributeOption3", "hook", "productAttributeOption3", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption3
		$I->createEntity("createConfigProductAttributeOption4", "hook", "productAttributeOption4", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption4
		$I->createEntity("createConfigProductAttributeOption5", "hook", "productAttributeOption5", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption5
		$I->comment("Add second attribute with options");
		$I->createEntity("createConfigProductAttribute2", "hook", "multipleSelectProductAttribute", [], []); // stepKey: createConfigProductAttribute2
		$I->createEntity("createConfigProductAttributeOption12", "hook", "productAttributeOption1", ["createConfigProductAttribute2"], []); // stepKey: createConfigProductAttributeOption12
		$I->createEntity("createConfigProductAttributeOption6", "hook", "productAttributeOption2", ["createConfigProductAttribute2"], []); // stepKey: createConfigProductAttributeOption6
		$I->createEntity("createConfigProductAttributeOption7", "hook", "productAttributeOption3", ["createConfigProductAttribute2"], []); // stepKey: createConfigProductAttributeOption7
		$I->createEntity("createConfigProductAttributeOption8", "hook", "productAttributeOption4", ["createConfigProductAttribute2"], []); // stepKey: createConfigProductAttributeOption8
		$I->comment("Login as Admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Add created attributes with options to Attribute Set");
		$I->comment("Entering Action Group [createDefaultAttributeSet] AdminAddUnassignedAttributeToGroupActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: goToAttributeSetsCreateDefaultAttributeSet
		$I->waitForPageLoad(30); // stepKey: wait1CreateDefaultAttributeSet
		$I->click("button.add-set"); // stepKey: clickAddAttributeSetCreateDefaultAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickAddAttributeSetCreateDefaultAttributeSetWaitForPageLoad
		$I->fillField("#attribute_set_name", "mySet"); // stepKey: fillNameCreateDefaultAttributeSet
		$I->click("button.save-attribute-set"); // stepKey: clickSave1CreateDefaultAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickSave1CreateDefaultAttributeSetWaitForPageLoad
		$I->dragAndDrop("//span[text()='" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute_code', 'hook') . "']", "//span[text()='Product Details']"); // stepKey: unassign1CreateDefaultAttributeSet
		$I->dragAndDrop("//span[text()='" . $I->retrieveEntityField('createConfigProductAttribute2', 'attribute_code', 'hook') . "']", "//span[text()='Product Details']"); // stepKey: unassign2CreateDefaultAttributeSet
		$I->click("button.save-attribute-set"); // stepKey: clickSaveButtonCreateDefaultAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonCreateDefaultAttributeSetWaitForPageLoad
		$I->comment("Exiting Action Group [createDefaultAttributeSet] AdminAddUnassignedAttributeToGroupActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete all created data");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createFirstConfigurableProduct", "hook"); // stepKey: deleteFirstProduct
		$I->deleteEntity("createSecondConfigurableProduct", "hook"); // stepKey: deleteSecondProduct
		$I->deleteEntity("createThirdConfigurableProduct", "hook"); // stepKey: deleteThirdProduct
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Delete attribute set");
		$I->comment("Entering Action Group [deleteAttributeSet] DeleteAttributeSetByLabelActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: goToAttributeSetsDeleteAttributeSet
		$I->waitForPageLoad(30); // stepKey: waitForAttributeSetPageLoadDeleteAttributeSet
		$I->fillField("#setGrid_filter_set_name", "mySet"); // stepKey: filterByNameDeleteAttributeSet
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
		$I->comment("Entering Action Group [clearAttributeSetsFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearAttributeSetsFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearAttributeSetsFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearAttributeSetsFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Delete First attribute");
		$I->comment("Entering Action Group [openProductAttributeFromSearchResultInGrid] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridOpenProductAttributeFromSearchResultInGrid
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridSectionLoadOpenProductAttributeFromSearchResultInGrid
		$I->fillField("#attributeGrid_filter_attribute_code", $I->retrieveEntityField('createConfigProductAttribute', 'attribute_code', 'hook')); // stepKey: setAttributeCodeOpenProductAttributeFromSearchResultInGrid
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOnGridToDisappearOpenProductAttributeFromSearchResultInGrid
		$I->waitForElementVisible("//td[contains(text(),'" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute_code', 'hook') . "')]", 30); // stepKey: waitForAdminProductAttributeGridLoadOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridLoadOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->see($I->retrieveEntityField('createConfigProductAttribute', 'attribute_code', 'hook'), "//div[@id='attributeGrid']//td[contains(@class,'col-attr-code col-attribute_code')]"); // stepKey: seeAttributeCodeInGridOpenProductAttributeFromSearchResultInGrid
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute_code', 'hook') . "')]"); // stepKey: clickAttributeToViewOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: clickAttributeToViewOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadOpenProductAttributeFromSearchResultInGrid
		$I->comment("Exiting Action Group [openProductAttributeFromSearchResultInGrid] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->comment("Entering Action Group [deleteProductAttributeByAttributeCode] DeleteProductAttributeByAttributeCodeActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadDeleteProductAttributeByAttributeCode
		$I->click("#delete"); // stepKey: deleteAttributeDeleteProductAttributeByAttributeCode
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteProductAttributeByAttributeCodeWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: clickOnConfirmOkDeleteProductAttributeByAttributeCode
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmOkDeleteProductAttributeByAttributeCodeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewProductAttributePageLoadDeleteProductAttributeByAttributeCode
		$I->comment("Exiting Action Group [deleteProductAttributeByAttributeCode] DeleteProductAttributeByAttributeCodeActionGroup");
		$I->comment("Delete Second attribute");
		$I->comment("Entering Action Group [openSecondProductAttributeFromSearchResultInGrid] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridOpenSecondProductAttributeFromSearchResultInGrid
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridOpenSecondProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridOpenSecondProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridSectionLoadOpenSecondProductAttributeFromSearchResultInGrid
		$I->fillField("#attributeGrid_filter_attribute_code", $I->retrieveEntityField('createConfigProductAttribute2', 'attribute_code', 'hook')); // stepKey: setAttributeCodeOpenSecondProductAttributeFromSearchResultInGrid
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridOpenSecondProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridOpenSecondProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOnGridToDisappearOpenSecondProductAttributeFromSearchResultInGrid
		$I->waitForElementVisible("//td[contains(text(),'" . $I->retrieveEntityField('createConfigProductAttribute2', 'attribute_code', 'hook') . "')]", 30); // stepKey: waitForAdminProductAttributeGridLoadOpenSecondProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridLoadOpenSecondProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->see($I->retrieveEntityField('createConfigProductAttribute2', 'attribute_code', 'hook'), "//div[@id='attributeGrid']//td[contains(@class,'col-attr-code col-attribute_code')]"); // stepKey: seeAttributeCodeInGridOpenSecondProductAttributeFromSearchResultInGrid
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('createConfigProductAttribute2', 'attribute_code', 'hook') . "')]"); // stepKey: clickAttributeToViewOpenSecondProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: clickAttributeToViewOpenSecondProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadOpenSecondProductAttributeFromSearchResultInGrid
		$I->comment("Exiting Action Group [openSecondProductAttributeFromSearchResultInGrid] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->comment("Entering Action Group [deleteSecondProductAttributeByAttributeCode] DeleteProductAttributeByAttributeCodeActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadDeleteSecondProductAttributeByAttributeCode
		$I->click("#delete"); // stepKey: deleteAttributeDeleteSecondProductAttributeByAttributeCode
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteSecondProductAttributeByAttributeCodeWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: clickOnConfirmOkDeleteSecondProductAttributeByAttributeCode
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmOkDeleteSecondProductAttributeByAttributeCodeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewProductAttributePageLoadDeleteSecondProductAttributeByAttributeCode
		$I->comment("Exiting Action Group [deleteSecondProductAttributeByAttributeCode] DeleteProductAttributeByAttributeCodeActionGroup");
		$I->comment("Entering Action Group [deleteProductAttributeSuccess] AssertProductAttributeRemovedSuccessfullyActionGroup");
		$I->seeElement(".message.message-success.success"); // stepKey: waitForSuccessMessageDeleteProductAttributeSuccess
		$I->comment("Exiting Action Group [deleteProductAttributeSuccess] AssertProductAttributeRemovedSuccessfullyActionGroup");
		$I->comment("Clear filters");
		$I->comment("Entering Action Group [clearProductAttributesFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearProductAttributesFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearProductAttributesFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductAttributesFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [clearProductsGridFilter] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearProductsGridFilter
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearProductsGridFilter
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearProductsGridFilter
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearProductsGridFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductsGridFilter] AdminClearFiltersActionGroup");
		$I->comment("Log out");
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
	 * @Stories({"Checking filters results"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckResultsOfColorAndOtherFiltersTest(AcceptanceTester $I)
	{
		$I->comment("Create three configurable products with options");
		$I->comment("Entering Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductGridPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductGridPage
		$I->comment("Exiting Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Edit created first product as configurable product with options");
		$I->comment("Entering Action Group [filterGridByFirstProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterGridByFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterGridByFirstProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterGridByFirstProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createFirstConfigurableProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterGridByFirstProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterGridByFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterGridByFirstProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterGridByFirstProduct
		$I->comment("Exiting Action Group [filterGridByFirstProduct] FilterProductGridBySkuActionGroup");
		$I->comment("Entering Action Group [openEditProductFirst] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createFirstConfigurableProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProductFirst
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProductFirst
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createFirstConfigurableProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProductFirst
		$I->comment("Exiting Action Group [openEditProductFirst] OpenEditProductOnBackendActionGroup");
		$I->comment("Entering Action Group [createProductFirst] CreateConfigurableProductWithAttributeSetActionGroup");
		$I->click("div[data-index='attribute_set_id'] .admin__field-control"); // stepKey: startEditAttrSetCreateProductFirst
		$I->fillField("div[data-index='attribute_set_id'] .admin__field-control input", "mySet"); // stepKey: searchForAttrSetCreateProductFirst
		$I->waitForPageLoad(30); // stepKey: searchForAttrSetCreateProductFirstWaitForPageLoad
		$I->click("div[data-index='attribute_set_id'] .action-menu-item._last"); // stepKey: selectAttrSetCreateProductFirst
		$I->waitForPageLoad(30); // stepKey: selectAttrSetCreateProductFirstWaitForPageLoad
		$I->fillField(".admin__field[data-index=name] input", $I->retrieveEntityField('createFirstConfigurableProduct', 'name', 'test')); // stepKey: fillNameCreateProductFirst
		$I->selectOption(".admin__control-multiselect", ['option1',  'option2',  'option3',  'option4']); // stepKey: searchAndMultiSelectCreatedOptionCreateProductFirst
		$I->comment("Exiting Action Group [createProductFirst] CreateConfigurableProductWithAttributeSetActionGroup");
		$I->comment("Entering Action Group [createConfigurationFirst] AdminCreateConfigurationsForAttributeActionGroup");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurationsCreateConfigurationFirst
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsCreateConfigurationFirstWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersCreateConfigurationFirst
		$I->fillField(".admin__control-text[name='attribute_code']", $I->retrieveEntityField('createConfigProductAttribute', 'attribute_code', 'test')); // stepKey: fillFilterAttributeCodeFieldCreateConfigurationFirst
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonCreateConfigurationFirst
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonCreateConfigurationFirstWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxCreateConfigurationFirst
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1CreateConfigurationFirst
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1CreateConfigurationFirstWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllCreateConfigurationFirst
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2CreateConfigurationFirst
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2CreateConfigurationFirstWaitForPageLoad
		$I->waitForElementVisible(".admin__field-label[for='apply-single-price-radio']", 30); // stepKey: waitForNextPageOpened2CreateConfigurationFirst
		$I->click(".admin__field-label[for='apply-single-price-radio']"); // stepKey: clickOnApplySinglePriceToAllSkusCreateConfigurationFirst
		$I->fillField("#apply-single-price-input", "34"); // stepKey: enterAttributePriceCreateConfigurationFirst
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuCreateConfigurationFirst
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuCreateConfigurationFirstWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "99"); // stepKey: enterAttributeQuantityCreateConfigurationFirst
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3CreateConfigurationFirst
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3CreateConfigurationFirstWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4CreateConfigurationFirst
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4CreateConfigurationFirstWaitForPageLoad
		$I->comment("Exiting Action Group [createConfigurationFirst] AdminCreateConfigurationsForAttributeActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitBtnFirst
		$I->waitForPageLoad(10); // stepKey: expandSplitBtnFirstWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveAndCloseFirst
		$I->waitForPageLoad(10); // stepKey: clickSaveAndCloseFirstWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForMessage
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessageFirst
		$I->comment("Edit created second product as configurable product with options");
		$I->comment("Entering Action Group [filterGridBySecondProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterGridBySecondProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterGridBySecondProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterGridBySecondProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSecondConfigurableProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterGridBySecondProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterGridBySecondProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterGridBySecondProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterGridBySecondProduct
		$I->comment("Exiting Action Group [filterGridBySecondProduct] FilterProductGridBySkuActionGroup");
		$I->comment("Entering Action Group [openEditProductSecond] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSecondConfigurableProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProductSecond
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProductSecond
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createSecondConfigurableProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProductSecond
		$I->comment("Exiting Action Group [openEditProductSecond] OpenEditProductOnBackendActionGroup");
		$I->comment("Entering Action Group [createProductSecond] CreateConfigurableProductWithAttributeSetActionGroup");
		$I->click("div[data-index='attribute_set_id'] .admin__field-control"); // stepKey: startEditAttrSetCreateProductSecond
		$I->fillField("div[data-index='attribute_set_id'] .admin__field-control input", "mySet"); // stepKey: searchForAttrSetCreateProductSecond
		$I->waitForPageLoad(30); // stepKey: searchForAttrSetCreateProductSecondWaitForPageLoad
		$I->click("div[data-index='attribute_set_id'] .action-menu-item._last"); // stepKey: selectAttrSetCreateProductSecond
		$I->waitForPageLoad(30); // stepKey: selectAttrSetCreateProductSecondWaitForPageLoad
		$I->fillField(".admin__field[data-index=name] input", $I->retrieveEntityField('createSecondConfigurableProduct', 'name', 'test')); // stepKey: fillNameCreateProductSecond
		$I->selectOption(".admin__control-multiselect", ['option1',  'option2',  'option3',  'option4']); // stepKey: searchAndMultiSelectCreatedOptionCreateProductSecond
		$I->comment("Exiting Action Group [createProductSecond] CreateConfigurableProductWithAttributeSetActionGroup");
		$I->comment("Entering Action Group [createConfigurationSecond] AdminCreateConfigurableProductWithAttributeUncheckOptionActionGroup");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurationsCreateConfigurationSecond
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsCreateConfigurationSecondWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersCreateConfigurationSecond
		$I->fillField(".admin__control-text[name='attribute_code']", $I->retrieveEntityField('createConfigProductAttribute', 'attribute_code', 'test')); // stepKey: fillFilterAttributeCodeFieldCreateConfigurationSecond
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonCreateConfigurationSecond
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonCreateConfigurationSecondWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxCreateConfigurationSecond
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1CreateConfigurationSecond
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1CreateConfigurationSecondWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllCreateConfigurationSecond
		$I->click("li[data-attribute-option-title='option5']"); // stepKey: clickToUncheckOptionCreateConfigurationSecond
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton22CreateConfigurationSecond
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton22CreateConfigurationSecondWaitForPageLoad
		$I->waitForElementVisible(".admin__field-label[for='apply-single-price-radio']", 30); // stepKey: waitForNextPageOpened2CreateConfigurationSecond
		$I->click(".admin__field-label[for='apply-single-price-radio']"); // stepKey: clickOnApplySinglePriceToAllSkusCreateConfigurationSecond
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2CreateConfigurationSecond
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2CreateConfigurationSecondWaitForPageLoad
		$I->fillField("#apply-single-price-input", "34"); // stepKey: enterAttributePriceCreateConfigurationSecond
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuCreateConfigurationSecond
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuCreateConfigurationSecondWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "99"); // stepKey: enterAttributeQuantityCreateConfigurationSecond
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3CreateConfigurationSecond
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3CreateConfigurationSecondWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4CreateConfigurationSecond
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4CreateConfigurationSecondWaitForPageLoad
		$I->comment("Exiting Action Group [createConfigurationSecond] AdminCreateConfigurableProductWithAttributeUncheckOptionActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadThird
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitBtnSecond
		$I->waitForPageLoad(10); // stepKey: expandSplitBtnSecondWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveAndCloseSecond
		$I->waitForPageLoad(10); // stepKey: clickSaveAndCloseSecondWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessage
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessageSecond
		$I->comment("Edit created third product as configurable product with options");
		$I->comment("Entering Action Group [filterGridByThirdProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterGridByThirdProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterGridByThirdProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterGridByThirdProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createThirdConfigurableProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterGridByThirdProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterGridByThirdProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterGridByThirdProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterGridByThirdProduct
		$I->comment("Exiting Action Group [filterGridByThirdProduct] FilterProductGridBySkuActionGroup");
		$I->comment("Entering Action Group [openEditProductThird] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createThirdConfigurableProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProductThird
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProductThird
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createThirdConfigurableProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProductThird
		$I->comment("Exiting Action Group [openEditProductThird] OpenEditProductOnBackendActionGroup");
		$I->comment("Entering Action Group [createProductThird] CreateConfigurableProductWithAttributeSetActionGroup");
		$I->click("div[data-index='attribute_set_id'] .admin__field-control"); // stepKey: startEditAttrSetCreateProductThird
		$I->fillField("div[data-index='attribute_set_id'] .admin__field-control input", "mySet"); // stepKey: searchForAttrSetCreateProductThird
		$I->waitForPageLoad(30); // stepKey: searchForAttrSetCreateProductThirdWaitForPageLoad
		$I->click("div[data-index='attribute_set_id'] .action-menu-item._last"); // stepKey: selectAttrSetCreateProductThird
		$I->waitForPageLoad(30); // stepKey: selectAttrSetCreateProductThirdWaitForPageLoad
		$I->fillField(".admin__field[data-index=name] input", $I->retrieveEntityField('createThirdConfigurableProduct', 'name', 'test')); // stepKey: fillNameCreateProductThird
		$I->selectOption(".admin__control-multiselect", ['option1',  'option2',  'option3',  'option4']); // stepKey: searchAndMultiSelectCreatedOptionCreateProductThird
		$I->comment("Exiting Action Group [createProductThird] CreateConfigurableProductWithAttributeSetActionGroup");
		$I->comment("Entering Action Group [createConfigurationThird] AdminCreateConfigurableProductWithAttributeUncheckOptionActionGroup");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurationsCreateConfigurationThird
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsCreateConfigurationThirdWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersCreateConfigurationThird
		$I->fillField(".admin__control-text[name='attribute_code']", $I->retrieveEntityField('createConfigProductAttribute', 'attribute_code', 'test')); // stepKey: fillFilterAttributeCodeFieldCreateConfigurationThird
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonCreateConfigurationThird
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonCreateConfigurationThirdWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxCreateConfigurationThird
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1CreateConfigurationThird
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1CreateConfigurationThirdWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllCreateConfigurationThird
		$I->click("li[data-attribute-option-title='option1']"); // stepKey: clickToUncheckOptionCreateConfigurationThird
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton22CreateConfigurationThird
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton22CreateConfigurationThirdWaitForPageLoad
		$I->waitForElementVisible(".admin__field-label[for='apply-single-price-radio']", 30); // stepKey: waitForNextPageOpened2CreateConfigurationThird
		$I->click(".admin__field-label[for='apply-single-price-radio']"); // stepKey: clickOnApplySinglePriceToAllSkusCreateConfigurationThird
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2CreateConfigurationThird
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2CreateConfigurationThirdWaitForPageLoad
		$I->fillField("#apply-single-price-input", "34"); // stepKey: enterAttributePriceCreateConfigurationThird
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuCreateConfigurationThird
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuCreateConfigurationThirdWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "99"); // stepKey: enterAttributeQuantityCreateConfigurationThird
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3CreateConfigurationThird
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3CreateConfigurationThirdWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4CreateConfigurationThird
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4CreateConfigurationThirdWaitForPageLoad
		$I->comment("Exiting Action Group [createConfigurationThird] AdminCreateConfigurableProductWithAttributeUncheckOptionActionGroup");
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitBtnThird
		$I->waitForPageLoad(10); // stepKey: expandSplitBtnThirdWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveAndCloseThird
		$I->waitForPageLoad(10); // stepKey: clickSaveAndCloseThirdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPage
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveConfigurableProductMessage
		$I->comment("Create Simple product with options");
		$I->comment("Entering Action Group [filterGridBySimpleProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterGridBySimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterGridBySimpleProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterGridBySimpleProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterGridBySimpleProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterGridBySimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterGridBySimpleProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterGridBySimpleProduct
		$I->comment("Exiting Action Group [filterGridBySimpleProduct] FilterProductGridBySkuActionGroup");
		$I->comment("Entering Action Group [openEditSimpleProduct] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditSimpleProduct
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditSimpleProduct
		$I->comment("Exiting Action Group [openEditSimpleProduct] OpenEditProductOnBackendActionGroup");
		$I->comment("Entering Action Group [createSimpleProduct] CreateConfigurableProductWithAttributeSetActionGroup");
		$I->click("div[data-index='attribute_set_id'] .admin__field-control"); // stepKey: startEditAttrSetCreateSimpleProduct
		$I->fillField("div[data-index='attribute_set_id'] .admin__field-control input", "mySet"); // stepKey: searchForAttrSetCreateSimpleProduct
		$I->waitForPageLoad(30); // stepKey: searchForAttrSetCreateSimpleProductWaitForPageLoad
		$I->click("div[data-index='attribute_set_id'] .action-menu-item._last"); // stepKey: selectAttrSetCreateSimpleProduct
		$I->waitForPageLoad(30); // stepKey: selectAttrSetCreateSimpleProductWaitForPageLoad
		$I->fillField(".admin__field[data-index=name] input", $I->retrieveEntityField('createSimpleProduct', 'name', 'test')); // stepKey: fillNameCreateSimpleProduct
		$I->selectOption(".admin__control-multiselect", ['option1',  'option2',  'option3',  'option4']); // stepKey: searchAndMultiSelectCreatedOptionCreateSimpleProduct
		$I->comment("Exiting Action Group [createSimpleProduct] CreateConfigurableProductWithAttributeSetActionGroup");
		$I->click("#save-button"); // stepKey: clickToSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickToSaveProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForNewSimpleProductPage
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessageThird
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
		$I->comment("Entering Action Group [goToCategoryPage] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendGoToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToCategoryPage
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: toCategoryGoToCategoryPage
		$I->waitForPageLoad(30); // stepKey: toCategoryGoToCategoryPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageGoToCategoryPage
		$I->comment("Exiting Action Group [goToCategoryPage] StorefrontGoToCategoryPageActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title'][text() = '" . $I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test') . "']", 30); // stepKey: waitForCartRuleButton
		$I->waitForPageLoad(30); // stepKey: waitForCartRuleButtonWaitForPageLoad
		$I->click("//div[@class='filter-options-title'][text() = '" . $I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test') . "']"); // stepKey: expandFirstAttribute
		$I->waitForPageLoad(30); // stepKey: expandFirstAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilterLoad
		$I->click("//div[contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test') . "')]//following-sibling::div//a[contains(text(), 'option2')]"); // stepKey: expandFirstAttributeOption
		$I->waitForPageLoad(30); // stepKey: waitForAttributeOption
		$I->seeElement("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('createFirstConfigurableProduct', 'name', 'test') . "')]"); // stepKey: seeFirstProduct
		$I->seeElement("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('createSecondConfigurableProduct', 'name', 'test') . "')]"); // stepKey: seeSecondProduct
		$I->seeElement("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('createThirdConfigurableProduct', 'name', 'test') . "')]"); // stepKey: seeSimpleProduct
		$I->comment("Entering Action Group [goToCategoryPageAgain] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendGoToCategoryPageAgain
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToCategoryPageAgain
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: toCategoryGoToCategoryPageAgain
		$I->waitForPageLoad(30); // stepKey: toCategoryGoToCategoryPageAgainWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageGoToCategoryPageAgain
		$I->comment("Exiting Action Group [goToCategoryPageAgain] StorefrontGoToCategoryPageActionGroup");
		$I->click("//div[@class='filter-options-title'][text() = '" . $I->retrieveEntityField('createConfigProductAttribute2', 'default_frontend_label', 'test') . "']"); // stepKey: expandSecondAttributeOption
		$I->waitForPageLoad(30); // stepKey: expandSecondAttributeOptionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilterPageLoad
		$I->click("//div[contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute2', 'default_frontend_label', 'test') . "')]//following-sibling::div//a[contains(text(), 'option1')]"); // stepKey: expandSecondAttribute
		$I->waitForPageLoad(30); // stepKey: waitForProductListLoad
		$I->seeElement("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('createFirstConfigurableProduct', 'name', 'test') . "')]"); // stepKey: seeFourthProduct
		$I->seeElement("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('createSecondConfigurableProduct', 'name', 'test') . "')]"); // stepKey: seeFifthProduct
	}
}
