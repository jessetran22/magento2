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
 * @Title("MC-11296: Move Product between Categories (Cron is ON, 'Update by Schedule' Mode)")
 * @Description("Verifies correctness of showing data (products, categories) on Storefront after moving an anchored category in terms of products/categories association<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminMoveProductBetweenCategoriesTest.xml<br>")
 * @TestCaseId("MC-11296")
 * @group catalog
 */
class AdminMoveProductBetweenCategoriesTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("simpleProduct", "hook", "defaultSimpleProduct", [], []); // stepKey: simpleProduct
		$I->createEntity("createAnchoredCategory1", "hook", "_defaultCategory", [], []); // stepKey: createAnchoredCategory1
		$I->createEntity("createSecondCategory", "hook", "_defaultCategory", [], []); // stepKey: createSecondCategory
		$I->comment("Switch \"Category Product\" and \"Product Category\" indexers to \"Update by Schedule\" mode");
		$I->comment("Entering Action Group [onIndexManagement] AdminOpenIndexManagementPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/indexer/indexer/list/"); // stepKey: openIndexManagementPageOnIndexManagement
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOnIndexManagement
		$I->comment("Exiting Action Group [onIndexManagement] AdminOpenIndexManagementPageActionGroup");
		$I->comment("Entering Action Group [switchCategoryProduct] AdminSwitchIndexerToActionModeActionGroup");
		$I->checkOption("input[value='catalog_category_product']"); // stepKey: checkIndexerSwitchCategoryProduct
		$I->selectOption("#gridIndexer_massaction-select", "Update by Schedule"); // stepKey: selectActionSwitchCategoryProduct
		$I->click("#gridIndexer_massaction-form button"); // stepKey: clickSubmitSwitchCategoryProduct
		$I->waitForPageLoad(30); // stepKey: waitForSubmitSwitchCategoryProduct
		$I->see("1 indexer(s) are in \"Update by Schedule\" mode.", "//*[@data-ui-id='messages-message-success']"); // stepKey: seeMessageSwitchCategoryProduct
		$I->waitForPageLoad(120); // stepKey: seeMessageSwitchCategoryProductWaitForPageLoad
		$I->comment("Exiting Action Group [switchCategoryProduct] AdminSwitchIndexerToActionModeActionGroup");
		$I->comment("Entering Action Group [switchProductCategory] AdminSwitchIndexerToActionModeActionGroup");
		$I->checkOption("input[value='catalog_product_category']"); // stepKey: checkIndexerSwitchProductCategory
		$I->selectOption("#gridIndexer_massaction-select", "Update by Schedule"); // stepKey: selectActionSwitchProductCategory
		$I->click("#gridIndexer_massaction-form button"); // stepKey: clickSubmitSwitchProductCategory
		$I->waitForPageLoad(30); // stepKey: waitForSubmitSwitchProductCategory
		$I->see("1 indexer(s) are in \"Update by Schedule\" mode.", "//*[@data-ui-id='messages-message-success']"); // stepKey: seeMessageSwitchProductCategory
		$I->waitForPageLoad(120); // stepKey: seeMessageSwitchProductCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [switchProductCategory] AdminSwitchIndexerToActionModeActionGroup");
		$I->comment("Entering Action Group [switchCatalogSearch] AdminSwitchIndexerToActionModeActionGroup");
		$I->checkOption("input[value='catalogsearch_fulltext']"); // stepKey: checkIndexerSwitchCatalogSearch
		$I->selectOption("#gridIndexer_massaction-select", "Update by Schedule"); // stepKey: selectActionSwitchCatalogSearch
		$I->click("#gridIndexer_massaction-form button"); // stepKey: clickSubmitSwitchCatalogSearch
		$I->waitForPageLoad(30); // stepKey: waitForSubmitSwitchCatalogSearch
		$I->see("1 indexer(s) are in \"Update by Schedule\" mode.", "//*[@data-ui-id='messages-message-success']"); // stepKey: seeMessageSwitchCatalogSearch
		$I->waitForPageLoad(120); // stepKey: seeMessageSwitchCatalogSearchWaitForPageLoad
		$I->comment("Exiting Action Group [switchCatalogSearch] AdminSwitchIndexerToActionModeActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Switch \"Category Product\" and \"Product Category\" indexers to \"Update by Save\" mode");
		$I->comment("Entering Action Group [onIndexManagement] AdminOpenIndexManagementPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/indexer/indexer/list/"); // stepKey: openIndexManagementPageOnIndexManagement
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOnIndexManagement
		$I->comment("Exiting Action Group [onIndexManagement] AdminOpenIndexManagementPageActionGroup");
		$I->comment("Entering Action Group [switchCategoryProduct] AdminSwitchIndexerToActionModeActionGroup");
		$I->checkOption("input[value='catalog_category_product']"); // stepKey: checkIndexerSwitchCategoryProduct
		$I->selectOption("#gridIndexer_massaction-select", "Update on Save"); // stepKey: selectActionSwitchCategoryProduct
		$I->click("#gridIndexer_massaction-form button"); // stepKey: clickSubmitSwitchCategoryProduct
		$I->waitForPageLoad(30); // stepKey: waitForSubmitSwitchCategoryProduct
		$I->see("1 indexer(s) are in \"Update on Save\" mode.", "//*[@data-ui-id='messages-message-success']"); // stepKey: seeMessageSwitchCategoryProduct
		$I->waitForPageLoad(120); // stepKey: seeMessageSwitchCategoryProductWaitForPageLoad
		$I->comment("Exiting Action Group [switchCategoryProduct] AdminSwitchIndexerToActionModeActionGroup");
		$I->comment("Entering Action Group [switchProductCategory] AdminSwitchIndexerToActionModeActionGroup");
		$I->checkOption("input[value='catalog_product_category']"); // stepKey: checkIndexerSwitchProductCategory
		$I->selectOption("#gridIndexer_massaction-select", "Update on Save"); // stepKey: selectActionSwitchProductCategory
		$I->click("#gridIndexer_massaction-form button"); // stepKey: clickSubmitSwitchProductCategory
		$I->waitForPageLoad(30); // stepKey: waitForSubmitSwitchProductCategory
		$I->see("1 indexer(s) are in \"Update on Save\" mode.", "//*[@data-ui-id='messages-message-success']"); // stepKey: seeMessageSwitchProductCategory
		$I->waitForPageLoad(120); // stepKey: seeMessageSwitchProductCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [switchProductCategory] AdminSwitchIndexerToActionModeActionGroup");
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createSecondCategory", "hook"); // stepKey: deleteSecondCategory
		$I->deleteEntity("createAnchoredCategory1", "hook"); // stepKey: deleteAnchoredCategory1
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
	 * @Stories({"Move Product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMoveProductBetweenCategoriesTest(AcceptanceTester $I)
	{
		$I->comment("Create the anchored category <Cat1_anchored>");
		$I->comment("Entering Action Group [anchorCategory] AdminAnchorCategoryActionGroup");
		$I->comment("Open Category page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageAnchorCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadedAnchorCategory
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeAnchorCategory
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadAnchorCategory
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createAnchoredCategory1', 'name', 'test') . "')]"); // stepKey: selectCategoryAnchorCategory
		$I->waitForPageLoad(30); // stepKey: selectCategoryAnchorCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAnchorCategory
		$I->comment("Enable Anchor for category");
		$I->scrollTo("//strong[@class='admin__collapsible-title']//span[text()='Display Settings']", 0, -80); // stepKey: scrollToDisplaySettingAnchorCategory
		$I->click("//strong[@class='admin__collapsible-title']//span[text()='Display Settings']"); // stepKey: selectDisplaySettingAnchorCategory
		$I->checkOption("input[name='is_anchor']"); // stepKey: enableAnchorAnchorCategory
		$I->click(".page-actions-inner #save"); // stepKey: saveSubCategoryAnchorCategory
		$I->waitForPageLoad(30); // stepKey: saveSubCategoryAnchorCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [anchorCategory] AdminAnchorCategoryActionGroup");
		$I->comment("Create subcategory <Sub1> of the anchored category");
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryButton
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryButtonWaitForPageLoad
		$I->fillField("input[name='name']", "SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: addSubCategoryName
		$I->comment("Entering Action Group [saveSubCategory1] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveSubCategory1
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveSubCategory1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveSubCategory1
		$I->comment("Exiting Action Group [saveSubCategory1] AdminSaveCategoryActionGroup");
		$I->seeElement(".message-success"); // stepKey: seeSaveSuccessMessage
		$I->comment("Assign <product1> to the <Sub1>");
		$I->comment("Entering Action Group [goToProduct] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('simpleProduct', 'id', 'test')); // stepKey: goToProductGoToProduct
		$I->comment("Exiting Action Group [goToProduct] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->click("div[data-index='category_ids']"); // stepKey: activateDropDownCategory
		$I->waitForPageLoad(30); // stepKey: activateDropDownCategoryWaitForPageLoad
		$I->fillField("//*[@data-index='category_ids']//input[contains(@class, 'multiselect-search')]", "SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: fillSearch
		$I->waitForPageLoad(30); // stepKey: fillSearchWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSubCategory
		$I->click("//*[@data-index='category_ids']//label[contains(., 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]"); // stepKey: selectSub1Category
		$I->waitForPageLoad(30); // stepKey: selectSub1CategoryWaitForPageLoad
		$I->comment("Entering Action Group [clickDone] AdminSubmitCategoriesPopupActionGroup");
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickOnDoneButtonClickDone
		$I->waitForPageLoad(30); // stepKey: clickOnDoneButtonClickDoneWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryApplyClickDone
		$I->comment("Exiting Action Group [clickDone] AdminSubmitCategoriesPopupActionGroup");
		$I->comment("Entering Action Group [clickSave] AdminProductFormSaveButtonClickActionGroup");
		$I->click("#save-button"); // stepKey: clickSaveButtonClickSave
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonClickSaveWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavedClickSave
		$I->comment("Exiting Action Group [clickSave] AdminProductFormSaveButtonClickActionGroup");
		$I->comment("Enable `Use Categories Path for Product URLs` on Stores -> Configuration -> Catalog -> Catalog -> Search Engine Optimization");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/catalog/"); // stepKey: onConfigPage
		$I->waitForPageLoad(30); // stepKey: waitForLoading
		$I->conditionalClick("#catalog_seo-head", "#catalog_seo-head.open", false); // stepKey: clickEngineOptimization
		$I->uncheckOption("#catalog_seo_product_use_categories_inherit"); // stepKey: uncheckDefault
		$I->selectOption("#catalog_seo_product_use_categories", "Yes"); // stepKey: selectYes
		$I->click("#save"); // stepKey: saveConfig
		$I->waitForPageLoad(30); // stepKey: waitForSaving
		$I->see("You saved the configuration.", "//*[@data-ui-id='messages-message-success']"); // stepKey: seeMessage
		$I->waitForPageLoad(120); // stepKey: seeMessageWaitForPageLoad
		$I->comment("Navigate to the Catalog > Products");
		$I->comment("Entering Action Group [onCatalogProductPage] AdminOpenCatalogProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openCatalogProductPageOnCatalogProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOnCatalogProductPage
		$I->comment("Exiting Action Group [onCatalogProductPage] AdminOpenCatalogProductPageActionGroup");
		$I->comment("Click on <product1>: Product page opens");
		$I->comment("Entering Action Group [filterProduct] FilterProductGridByNameActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProduct
		$I->fillField("input.admin__control-text[name='name']", $I->retrieveEntityField('simpleProduct', 'name', 'test')); // stepKey: fillProductNameFilterFilterProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProduct
		$I->comment("Exiting Action Group [filterProduct] FilterProductGridByNameActionGroup");
		$I->click("//tbody//tr//td//div[contains(., '" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "')]"); // stepKey: clickProduct1
		$I->waitForPageLoad(30); // stepKey: clickProduct1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductLoad
		$I->comment("Clear \"Categories\" field and assign the product to <Cat2> and save the product");
		$grabNameSubCategory = $I->grabTextFrom(".admin__action-multiselect-crumb > span"); // stepKey: grabNameSubCategory
		$I->click("//span[@class='admin__action-multiselect-crumb']/span[contains(.,'SimpleSubCategory" . msq("SimpleSubCategory") . "')]/../button[@data-action='remove-selected-item']"); // stepKey: removeCategory
		$I->waitForPageLoad(30); // stepKey: removeCategoryWaitForPageLoad
		$I->click("div[data-index='category_ids']"); // stepKey: openDropDown
		$I->waitForPageLoad(30); // stepKey: openDropDownWaitForPageLoad
		$I->checkOption("//*[@data-index='category_ids']//label[contains(., '" . $I->retrieveEntityField('createSecondCategory', 'name', 'test') . "')]"); // stepKey: selectCategory
		$I->waitForPageLoad(30); // stepKey: selectCategoryWaitForPageLoad
		$I->comment("Entering Action Group [pressButtonDone] AdminSubmitCategoriesPopupActionGroup");
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickOnDoneButtonPressButtonDone
		$I->waitForPageLoad(30); // stepKey: clickOnDoneButtonPressButtonDoneWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryApplyPressButtonDone
		$I->comment("Exiting Action Group [pressButtonDone] AdminSubmitCategoriesPopupActionGroup");
		$I->comment("Entering Action Group [pushButtonSave] AdminProductFormSaveButtonClickActionGroup");
		$I->click("#save-button"); // stepKey: clickSaveButtonPushButtonSave
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonPushButtonSaveWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavedPushButtonSave
		$I->comment("Exiting Action Group [pushButtonSave] AdminProductFormSaveButtonClickActionGroup");
		$I->comment("Product is saved");
		$I->see("You saved the product.", "//div[@data-ui-id='messages-message-success']"); // stepKey: seeSuccessMessage
		$I->comment("Run cron");
		$runCron = $I->magentoCLI("cron:run --group=index", 60); // stepKey: runCron
		$I->comment($runCron);
		$I->comment("Clear invalidated cache on System>Tools>Cache Management page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/cache"); // stepKey: onCachePage
		$I->waitForPageLoad(30); // stepKey: waitForCacheManagementPage
		$I->checkOption("input[value='config']"); // stepKey: checkConfigCache
		$I->checkOption("input[value='full_page']"); // stepKey: checkPageCache
		$I->selectOption("#cache_grid_massaction-form #cache_grid_massaction-select", "Refresh"); // stepKey: selectRefresh
		$I->waitForElementVisible("#cache_grid_massaction-form button", 30); // stepKey: waitSubmitButton
		$I->click("#cache_grid_massaction-form button"); // stepKey: clickSubmit
		$I->waitForPageLoad(30); // stepKey: waitForRefresh
		$I->see("2 cache type(s) refreshed."); // stepKey: seeCacheRefreshedMessage
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Open frontend");
		$I->comment("Entering Action Group [onFrontend] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOnFrontend
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOnFrontend
		$I->comment("Exiting Action Group [onFrontend] StorefrontOpenHomePageActionGroup");
		$I->comment("Open <Cat2> from navigation menu");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createSecondCategory', 'name', 'test') . "')]]"); // stepKey: openCat2
		$I->waitForPageLoad(30); // stepKey: openCat2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategory2Page
		$I->comment("# <Cat 2> should open # <product1> should be present on the page");
		$I->see($I->retrieveEntityField('createSecondCategory', 'name', 'test'), "#page-title-heading span"); // stepKey: seeCategoryName
		$I->see($I->retrieveEntityField('simpleProduct', 'name', 'test'), ".product-item-name"); // stepKey: seeProduct
		$I->comment("Open <product1>");
		$I->click("a.product-item-link[href$='" . $I->retrieveEntityField('simpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: openProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoading
		$I->comment("# Product page should open successfully # Breadcrumb for product should be like <Cat 2>");
		$I->see($I->retrieveEntityField('simpleProduct', 'name', 'test'), ".base"); // stepKey: seeProductName
		$I->see($I->retrieveEntityField('createSecondCategory', 'name', 'test'), ".breadcrumbs li"); // stepKey: seeCategoryInBreadcrumbs
		$I->comment("Open <Cat1_anchored> category");
		$I->click("//a[contains(@class,'level-top')]/span[contains(text(),'" . $I->retrieveEntityField('createAnchoredCategory1', 'name', 'test') . "')]"); // stepKey: clickCat1
		$I->waitForPageLoad(30); // stepKey: waitForCategory1PageLoad
		$I->comment("# Category should open successfully # <product1> should be absent on the page");
		$I->see($I->retrieveEntityField('createAnchoredCategory1', 'name', 'test'), "#page-title-heading span"); // stepKey: seeCategory1Name
		$I->comment("Entering Action Group [seeEmptyNotice] AssertStorefrontNoProductsFoundActionGroup");
		$I->see("We can't find products matching the selection."); // stepKey: seeEmptyNoticeSeeEmptyNotice
		$I->comment("Exiting Action Group [seeEmptyNotice] AssertStorefrontNoProductsFoundActionGroup");
		$I->dontSee($I->retrieveEntityField('simpleProduct', 'name', 'test'), ".product-item-name"); // stepKey: dontseeProduct
		$I->comment("Log in to the backend: Admin user is logged in");
		$I->comment("Entering Action Group [LoginAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAdmin
		$I->comment("Exiting Action Group [LoginAdmin] AdminLoginActionGroup");
		$I->comment("Navigate to the Catalog > Products: Navigate to the Catalog>Products");
		$I->comment("Entering Action Group [amOnProductPage] AdminOpenCatalogProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openCatalogProductPageAmOnProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAmOnProductPage
		$I->comment("Exiting Action Group [amOnProductPage] AdminOpenCatalogProductPageActionGroup");
		$I->comment("Click on <product1>");
		$I->comment("Entering Action Group [openSimpleProduct] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageOpenSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadOpenSimpleProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersOpenSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersOpenSimpleProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersOpenSimpleProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterOpenSimpleProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersOpenSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersOpenSimpleProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadOpenSimpleProduct
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('simpleProduct', 'sku', 'test') . "']]"); // stepKey: openSelectedProductOpenSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadOpenSimpleProduct
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleOpenSimpleProduct
		$I->comment("Exiting Action Group [openSimpleProduct] FilterAndSelectProductActionGroup");
		$I->comment("Clear \"Categories\" field and assign the product to <Sub1> and save the product");
		$I->click("//span[@class='admin__action-multiselect-crumb']/span[contains(.,'" . $I->retrieveEntityField('createSecondCategory', 'name', 'test') . "')]/../button[@data-action='remove-selected-item']"); // stepKey: clearCategory
		$I->waitForPageLoad(30); // stepKey: clearCategoryWaitForPageLoad
		$I->click("div[data-index='category_ids']"); // stepKey: activateDropDown
		$I->waitForPageLoad(30); // stepKey: activateDropDownWaitForPageLoad
		$I->fillField("//*[@data-index='category_ids']//input[contains(@class, 'multiselect-search')]", $grabNameSubCategory); // stepKey: fillSearchField
		$I->waitForPageLoad(30); // stepKey: fillSearchFieldWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchSubCategory
		$I->click("//*[@data-index='category_ids']//label[contains(., '{$grabNameSubCategory}')]"); // stepKey: selectSubCategory
		$I->waitForPageLoad(30); // stepKey: selectSubCategoryWaitForPageLoad
		$I->comment("Entering Action Group [clickButtonDone] AdminSubmitCategoriesPopupActionGroup");
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickOnDoneButtonClickButtonDone
		$I->waitForPageLoad(30); // stepKey: clickOnDoneButtonClickButtonDoneWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryApplyClickButtonDone
		$I->comment("Exiting Action Group [clickButtonDone] AdminSubmitCategoriesPopupActionGroup");
		$I->comment("Entering Action Group [clickButtonSave] AdminProductFormSaveButtonClickActionGroup");
		$I->click("#save-button"); // stepKey: clickSaveButtonClickButtonSave
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonClickButtonSaveWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavedClickButtonSave
		$I->comment("Exiting Action Group [clickButtonSave] AdminProductFormSaveButtonClickActionGroup");
		$I->comment("Product is saved successfully");
		$I->see("You saved the product.", "//div[@data-ui-id='messages-message-success']"); // stepKey: seeSaveMessage
		$I->comment("Run cron");
		$runCron2 = $I->magentoCLI("cron:run --group=index", 60); // stepKey: runCron2
		$I->comment($runCron2);
		$I->comment("Open frontend");
		$I->comment("Entering Action Group [onFrontendPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOnFrontendPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOnFrontendPage
		$I->comment("Exiting Action Group [onFrontendPage] StorefrontOpenHomePageActionGroup");
		$I->comment("Open <Cat2> from navigation menu");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createSecondCategory', 'name', 'test') . "')]]"); // stepKey: openSecondCategory
		$I->waitForPageLoad(30); // stepKey: openSecondCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSecondCategoryPage
		$I->comment("# <Cat 2> should open # <product1> should be absent on the page");
		$I->see($I->retrieveEntityField('createSecondCategory', 'name', 'test'), "#page-title-heading span"); // stepKey: seeSecondCategory1Name
		$I->dontSee($I->retrieveEntityField('simpleProduct', 'name', 'test'), ".product-item-name"); // stepKey: dontseeSimpleProduct
		$I->comment("Click on <Cat1_anchored> category");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createAnchoredCategory1', 'name', 'test') . "')]]"); // stepKey: clickAnchoredCategory
		$I->waitForPageLoad(30); // stepKey: clickAnchoredCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAnchoredCategoryPage
		$I->comment("# Category should open successfully # <product1> should be present on the page");
		$I->see($I->retrieveEntityField('createAnchoredCategory1', 'name', 'test'), "#page-title-heading span"); // stepKey: see1CategoryName
		$I->see($I->retrieveEntityField('simpleProduct', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameOnCategory1Page
		$I->comment("Breadcrumb for product should be like <Cat1_anchored>/<product> (if you clicks from anchor category)");
		$I->see($I->retrieveEntityField('createAnchoredCategory1', 'name', 'test'), ".breadcrumbs li"); // stepKey: seeCat1inBreadcrumbs
		$I->dontSee($grabNameSubCategory, ".breadcrumbs li"); // stepKey: dontSeeSubCategoryInBreadCrumbs
		$I->comment("<Cat1_anchored>/<Sub1>/<product> (if you clicks from Sub1 category)");
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createAnchoredCategory1', 'name', 'test') . "')]]"); // stepKey: hoverCategory1
		$I->waitForPageLoad(30); // stepKey: hoverCategory1WaitForPageLoad
		$I->click("//nav//a[span[contains(., '{$grabNameSubCategory}')]]"); // stepKey: clickSubCat
		$I->waitForPageLoad(30); // stepKey: clickSubCatWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSubCategoryPageLoad
		$I->see($grabNameSubCategory, "#page-title-heading span"); // stepKey: seeSubCategoryName
		$I->see($I->retrieveEntityField('simpleProduct', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameOnSubCategoryPage
		$I->see($grabNameSubCategory, ".breadcrumbs li"); // stepKey: seeSubCategoryInBreadcrumbs
		$I->see($I->retrieveEntityField('createAnchoredCategory1', 'name', 'test'), ".breadcrumbs li"); // stepKey: seeCat1InBreadcrumbs
	}
}
