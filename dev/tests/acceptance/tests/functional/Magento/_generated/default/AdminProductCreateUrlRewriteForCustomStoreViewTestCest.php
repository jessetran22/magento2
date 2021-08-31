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
 * @Title("MC-6463: Product custom URL Key is preserved when assigned to a Category")
 * @Description("Verify Product custom URL Key (for custom Store View) is preserved when assigned to a Category (with custom URL Key) alongside with another Product without custom URL Key<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminProductCreateUrlRewriteForCustomStoreViewTest.xml<br>")
 * @TestCaseId("MC-6463")
 * @group catalog
 * @group url_rewrite
 */
class AdminProductCreateUrlRewriteForCustomStoreViewTestCest
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
		$I->createEntity("createProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->createEntity("createProductForUrlRewrite", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProductForUrlRewrite
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create second store view");
		$I->comment("Entering Action Group [createCustomStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateCustomStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateCustomStoreView
		$I->fillField("#store_name", "store" . msq("customStore")); // stepKey: enterStoreViewNameCreateCustomStoreView
		$I->fillField("#store_code", "store" . msq("customStore")); // stepKey: enterStoreViewCodeCreateCustomStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateCustomStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateCustomStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateCustomStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateCustomStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateCustomStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateCustomStoreView
		$I->comment("Exiting Action Group [createCustomStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Entering Action Group [runReindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersRunReindex = $I->magentoCLI("indexer:reindex", 60, "catalog_category_product"); // stepKey: reindexSpecifiedIndexersRunReindex
		$I->comment($reindexSpecifiedIndexersRunReindex);
		$I->comment("Exiting Action Group [runReindex] CliIndexerReindexActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createProductForUrlRewrite", "hook"); // stepKey: deleteProductForUrlRewrite
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [deleteStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "store" . msq("customStore")); // stepKey: fillStoreViewFilterFieldDeleteStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView
		$I->comment("Exiting Action Group [deleteStoreView] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [clearFilterForStores] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopClearFilterForStores
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersClearFilterForStores
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetClearFilterForStores
		$I->comment("Exiting Action Group [clearFilterForStores] AdminGridFilterResetActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Features({"UrlRewrite"})
	 * @Stories({"Create Product"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminProductCreateUrlRewriteForCustomStoreViewTest(AcceptanceTester $I)
	{
		$I->comment("Step 1. Navigate as Admin on Product Page for edit product`s Url Key");
		$I->comment("Entering Action Group [goToProductForUrlRewrite] NavigateToCreatedProductEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToAdminProductIndexPageGoToProductForUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadGoToProductForUrlRewrite
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersGoToProductForUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersGoToProductForUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersGoToProductForUrlRewrite
		$I->dontSeeElement(".admin__data-grid-header button[data-action='grid-filter-reset']"); // stepKey: dontSeeClearFiltersGoToProductForUrlRewrite
		$I->waitForPageLoad(30); // stepKey: dontSeeClearFiltersGoToProductForUrlRewriteWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabGoToProductForUrlRewrite
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewGoToProductForUrlRewrite
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewGoToProductForUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResetToDefaultViewGoToProductForUrlRewrite
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedGoToProductForUrlRewrite
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersGoToProductForUrlRewrite
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createProductForUrlRewrite', 'sku', 'test')); // stepKey: fillProductSkuFilterGoToProductForUrlRewrite
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersGoToProductForUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersGoToProductForUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilterOnGridGoToProductForUrlRewrite
		$I->click("//td/div[text()='" . $I->retrieveEntityField('createProductForUrlRewrite', 'name', 'test') . "']"); // stepKey: clickProductGoToProductForUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoadGoToProductForUrlRewrite
		$I->waitForElementVisible("//*[@name='product[sku]']", 30); // stepKey: waitForProductSKUFieldGoToProductForUrlRewrite
		$I->seeInField("//*[@name='product[sku]']", $I->retrieveEntityField('createProductForUrlRewrite', 'sku', 'test')); // stepKey: seeProductSKUGoToProductForUrlRewrite
		$I->comment("Exiting Action Group [goToProductForUrlRewrite] NavigateToCreatedProductEditPageActionGroup");
		$I->comment("Step 2. As Admin switch on Custom Store View from Precondition");
		$I->comment("Entering Action Group [switchToCustomStore] AdminSwitchStoreViewActionGroup");
		$I->click("#store-change-button"); // stepKey: clickStoreViewSwitchDropdownSwitchToCustomStore
		$I->waitForElementVisible("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]", 30); // stepKey: waitForStoreViewsAreVisibleSwitchToCustomStore
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewsAreVisibleSwitchToCustomStoreWaitForPageLoad
		$I->click("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'store" . msq("customStore") . "')]"); // stepKey: clickStoreViewByNameSwitchToCustomStore
		$I->waitForPageLoad(30); // stepKey: clickStoreViewByNameSwitchToCustomStoreWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalSwitchToCustomStore
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalSwitchToCustomStoreWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchSwitchToCustomStore
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchSwitchToCustomStoreWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewSwitchedSwitchToCustomStore
		$I->scrollToTopOfPage(); // stepKey: scrollToStoreSwitcherSwitchToCustomStore
		$I->see("store" . msq("customStore"), ".store-switcher"); // stepKey: seeNewStoreViewNameSwitchToCustomStore
		$I->comment("Exiting Action Group [switchToCustomStore] AdminSwitchStoreViewActionGroup");
		$I->comment("Step 3. Set custom URL Key for product on Custom StoreView");
		$I->comment("Entering Action Group [updateUrlKeyForProduct] AdminProductFormUpdateUrlKeyActionGroup");
		$I->conditionalClick("div[data-index='search-engine-optimization']", "input[name='use_default[url_key]']", false); // stepKey: clickOnSearchEngineOptimizationUpdateUrlKeyForProduct
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitLoadProductFormUpdateUrlKeyForProduct
		$I->uncheckOption("input[name='use_default[url_key]']"); // stepKey: uncheckDefaultUrlUpdateUrlKeyForProduct
		$I->fillField("input[name='product[url_key]']", "U2"); // stepKey: changeUrlKeyUpdateUrlKeyForProduct
		$I->comment("Exiting Action Group [updateUrlKeyForProduct] AdminProductFormUpdateUrlKeyActionGroup");
		$I->comment("Entering Action Group [saveProductWithNewUrl] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductWithNewUrl
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductWithNewUrl
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWithNewUrlWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductWithNewUrl
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWithNewUrlWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductWithNewUrl
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductWithNewUrl
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductWithNewUrl
		$I->comment("Exiting Action Group [saveProductWithNewUrl] SaveProductFormActionGroup");
		$I->comment("Step 4. Set URL Key for created category");
		$I->comment("Entering Action Group [navigateToCreatedSubCategory] NavigateToCreatedCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageNavigateToCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedSubCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllNavigateToCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedSubCategory
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategory', 'Name', 'test') . "')]"); // stepKey: navigateToCreatedCategoryNavigateToCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategoryNavigateToCreatedSubCategoryWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerNavigateToCreatedSubCategory
		$I->comment("Exiting Action Group [navigateToCreatedSubCategory] NavigateToCreatedCategoryActionGroup");
		$I->comment("Entering Action Group [updateUrlKeyForCategory] ChangeSeoUrlKeyActionGroup");
		$I->conditionalClick("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", "div[data-index='search_engine_optimization'] .admin__fieldset-wrapper-content", false); // stepKey: openSeoSectionUpdateUrlKeyForCategory
		$I->fillField("input[name='url_key']", "U1"); // stepKey: enterURLKeyUpdateUrlKeyForCategory
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryUpdateUrlKeyForCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryUpdateUrlKeyForCategoryWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageUpdateUrlKeyForCategory
		$I->comment("Exiting Action Group [updateUrlKeyForCategory] ChangeSeoUrlKeyActionGroup");
		$I->comment("Step 5. On Storefront Assert what URL Key for Category is changed and is correct as for Default Store View");
		$I->comment("Entering Action Group [onCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadOnCategoryPage
		$I->comment("Exiting Action Group [onCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertUrlCategoryOnDefaultStore] AssertStorefrontUrlRewriteRedirectActionGroup");
		$I->amOnPage("u1.html"); // stepKey: openCategoryInStorefrontAssertUrlCategoryOnDefaultStore
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadAssertUrlCategoryOnDefaultStore
		$I->seeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: seeCategoryOnStoreNavigationBarAssertUrlCategoryOnDefaultStore
		$I->waitForPageLoad(30); // stepKey: seeCategoryOnStoreNavigationBarAssertUrlCategoryOnDefaultStoreWaitForPageLoad
		$I->seeElement("#page-title-heading span"); // stepKey: seeCategoryInTitleAssertUrlCategoryOnDefaultStore
		$I->comment("Exiting Action Group [assertUrlCategoryOnDefaultStore] AssertStorefrontUrlRewriteRedirectActionGroup");
		$I->comment("Step 6. On Storefront Assert what URL Key for product is correct(as initial URL)");
		$I->comment("Entering Action Group [navigateToProductInDefaultStore] OpenProductFromCategoryPageActionGroup");
		$I->comment("Go to storefront category page");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_path]', 'test') . ".html"); // stepKey: navigateToCategoryPageNavigateToProductInDefaultStore
		$I->comment("Go to storefront product page");
		$I->click("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]"); // stepKey: openProductPageNavigateToProductInDefaultStore
		$I->waitForAjaxLoad(30); // stepKey: waitForImageLoaderNavigateToProductInDefaultStore
		$I->comment("Exiting Action Group [navigateToProductInDefaultStore] OpenProductFromCategoryPageActionGroup");
		$I->comment("Entering Action Group [checkProductUrl] StorefrontCheckProductUrlActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCheckProductUrl
		$I->comment("Exiting Action Group [checkProductUrl] StorefrontCheckProductUrlActionGroup");
		$I->comment("Step 7. On Storefront Assert what URL Key for product is correct for Default Store View (as initial URL)");
		$I->comment("Entering Action Group [navigateToProductForUrlRewriteInDefaultStore] OpenProductFromCategoryPageActionGroup");
		$I->comment("Go to storefront category page");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_path]', 'test') . ".html"); // stepKey: navigateToCategoryPageNavigateToProductForUrlRewriteInDefaultStore
		$I->comment("Go to storefront product page");
		$I->click("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('createProductForUrlRewrite', 'name', 'test') . "')]"); // stepKey: openProductPageNavigateToProductForUrlRewriteInDefaultStore
		$I->waitForAjaxLoad(30); // stepKey: waitForImageLoaderNavigateToProductForUrlRewriteInDefaultStore
		$I->comment("Exiting Action Group [navigateToProductForUrlRewriteInDefaultStore] OpenProductFromCategoryPageActionGroup");
		$I->comment("Entering Action Group [checkProductWithChangedUrl] StorefrontCheckProductUrlActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createProductForUrlRewrite', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCheckProductWithChangedUrl
		$I->comment("Exiting Action Group [checkProductWithChangedUrl] StorefrontCheckProductUrlActionGroup");
		$I->comment("Step 8. On Storefront switch on created Custom Store View");
		$I->comment("Entering Action Group [switchToCustomStoreViewOnStorefront] StorefrontSwitchStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherSwitchToCustomStoreViewOnStorefront
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownSwitchToCustomStoreViewOnStorefront
		$I->click("li.view-store" . msq("customStore") . ">a"); // stepKey: clickSelectStoreViewSwitchToCustomStoreViewOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchToCustomStoreViewOnStorefront
		$I->comment("Exiting Action Group [switchToCustomStoreViewOnStorefront] StorefrontSwitchStoreViewActionGroup");
		$I->comment("Step 9. On Storefront Assert what URL Key for Category is changed and is correct for Custom Store View");
		$I->comment("Entering Action Group [assertUrlCategoryOnCustomStore] AssertStorefrontUrlRewriteRedirectActionGroup");
		$I->amOnPage("u1.html"); // stepKey: openCategoryInStorefrontAssertUrlCategoryOnCustomStore
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadAssertUrlCategoryOnCustomStore
		$I->seeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: seeCategoryOnStoreNavigationBarAssertUrlCategoryOnCustomStore
		$I->waitForPageLoad(30); // stepKey: seeCategoryOnStoreNavigationBarAssertUrlCategoryOnCustomStoreWaitForPageLoad
		$I->seeElement("#page-title-heading span"); // stepKey: seeCategoryInTitleAssertUrlCategoryOnCustomStore
		$I->comment("Exiting Action Group [assertUrlCategoryOnCustomStore] AssertStorefrontUrlRewriteRedirectActionGroup");
		$I->comment("Step 10. On Storefront Assert what URL Key for product is correct for Custom Store View (as initial URL)");
		$I->comment("Entering Action Group [navigateToProductInCustomStore] OpenProductFromCategoryPageActionGroup");
		$I->comment("Go to storefront category page");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_path]', 'test') . ".html"); // stepKey: navigateToCategoryPageNavigateToProductInCustomStore
		$I->comment("Go to storefront product page");
		$I->click("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]"); // stepKey: openProductPageNavigateToProductInCustomStore
		$I->waitForAjaxLoad(30); // stepKey: waitForImageLoaderNavigateToProductInCustomStore
		$I->comment("Exiting Action Group [navigateToProductInCustomStore] OpenProductFromCategoryPageActionGroup");
		$I->comment("Entering Action Group [checkProductUrlOnCustomStore] StorefrontCheckProductUrlActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCheckProductUrlOnCustomStore
		$I->comment("Exiting Action Group [checkProductUrlOnCustomStore] StorefrontCheckProductUrlActionGroup");
		$I->comment("Step 11. On Storefront Assert what URL Key for product is changed and is correct for Custom Store View");
		$I->comment("Entering Action Group [assertProductUrlRewriteInStoreFront] AssertStorefrontProductRedirectActionGroup");
		$I->amOnPage("u2.html"); // stepKey: openCategoryInStorefrontAssertProductUrlRewriteInStoreFront
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadAssertProductUrlRewriteInStoreFront
		$I->see($I->retrieveEntityField('createProductForUrlRewrite', 'name', 'test'), ".base"); // stepKey: seeProductNameInStoreFrontPageAssertProductUrlRewriteInStoreFront
		$I->see($I->retrieveEntityField('createProductForUrlRewrite', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: seeProductSkuInStoreFrontPageAssertProductUrlRewriteInStoreFront
		$I->comment("Exiting Action Group [assertProductUrlRewriteInStoreFront] AssertStorefrontProductRedirectActionGroup");
	}
}
