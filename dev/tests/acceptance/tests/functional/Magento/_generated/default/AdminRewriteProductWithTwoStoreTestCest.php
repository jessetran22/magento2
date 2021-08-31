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
 * @Title("[NO TESTCASEID]: Rewriting URL of product")
 * @Description("Rewriting URL of product. Verify the full URL address<h3>Test files</h3>app/code/Magento/CatalogUrlRewrite/Test/Mftf/Test/AdminRewriteProductWithTwoStoreTest.xml<br>")
 * @group CatalogUrlRewrite
 */
class AdminRewriteProductWithTwoStoreTestCest
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
		$enableUseCategoriesPath = $I->magentoCLI("config:set catalog/seo/product_use_categories 1", 60); // stepKey: enableUseCategoriesPath
		$I->comment($enableUseCategoriesPath);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [createStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreView
		$I->fillField("#store_name", "store" . msq("customStore")); // stepKey: enterStoreViewNameCreateStoreView
		$I->fillField("#store_code", "store" . msq("customStore")); // stepKey: enterStoreViewCodeCreateStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreView
		$I->comment("Exiting Action Group [createStoreView] AdminCreateStoreViewActionGroup");
		$I->createEntity("defaultCategory", "hook", "_defaultCategoryDifferentUrlStore", [], []); // stepKey: defaultCategory
		$I->createEntity("subCategory", "hook", "SimpleSubCategoryDifferentUrlStore", ["defaultCategory"], []); // stepKey: subCategory
		$I->createEntity("simpleProduct", "hook", "SimpleProduct", ["subCategory"], []); // stepKey: simpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
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
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("defaultCategory", "hook"); // stepKey: deleteNewRootCategory
		$disableUseCategoriesPath = $I->magentoCLI("config:set catalog/seo/product_use_categories 0", 60); // stepKey: disableUseCategoriesPath
		$I->comment($disableUseCategoriesPath);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
	 * @Stories({"Rewriting URL of product"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"CatalogUrlRewrite"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminRewriteProductWithTwoStoreTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToCreatedDefaultCategory] NavigateToCreatedCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageNavigateToCreatedDefaultCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedDefaultCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllNavigateToCreatedDefaultCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedDefaultCategory
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('defaultCategory', 'Name', 'test') . "')]"); // stepKey: navigateToCreatedCategoryNavigateToCreatedDefaultCategory
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategoryNavigateToCreatedDefaultCategoryWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerNavigateToCreatedDefaultCategory
		$I->comment("Exiting Action Group [navigateToCreatedDefaultCategory] NavigateToCreatedCategoryActionGroup");
		$I->comment("Entering Action Group [AdminSwitchDefaultStoreViewForDefaultCategory] AdminSwitchStoreViewActionGroup");
		$I->click("#store-change-button"); // stepKey: clickStoreViewSwitchDropdownAdminSwitchDefaultStoreViewForDefaultCategory
		$I->waitForElementVisible("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]", 30); // stepKey: waitForStoreViewsAreVisibleAdminSwitchDefaultStoreViewForDefaultCategory
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewsAreVisibleAdminSwitchDefaultStoreViewForDefaultCategoryWaitForPageLoad
		$I->click("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]"); // stepKey: clickStoreViewByNameAdminSwitchDefaultStoreViewForDefaultCategory
		$I->waitForPageLoad(30); // stepKey: clickStoreViewByNameAdminSwitchDefaultStoreViewForDefaultCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalAdminSwitchDefaultStoreViewForDefaultCategory
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalAdminSwitchDefaultStoreViewForDefaultCategoryWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchAdminSwitchDefaultStoreViewForDefaultCategory
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchAdminSwitchDefaultStoreViewForDefaultCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewSwitchedAdminSwitchDefaultStoreViewForDefaultCategory
		$I->scrollToTopOfPage(); // stepKey: scrollToStoreSwitcherAdminSwitchDefaultStoreViewForDefaultCategory
		$I->see("Default Store View", ".store-switcher"); // stepKey: seeNewStoreViewNameAdminSwitchDefaultStoreViewForDefaultCategory
		$I->comment("Exiting Action Group [AdminSwitchDefaultStoreViewForDefaultCategory] AdminSwitchStoreViewActionGroup");
		$I->comment("Entering Action Group [changeSeoUrlKeyForDefaultCategoryDefaultStore] AdminChangeSeoUrlKeyForSubCategoryWithoutRedirectActionGroup");
		$I->conditionalClick("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", "div[data-index='search_engine_optimization'] .admin__fieldset-wrapper-content", false); // stepKey: openSeoSectionChangeSeoUrlKeyForDefaultCategoryDefaultStore
		$I->uncheckOption("input[name='use_default[url_key]']"); // stepKey: uncheckDefaultValueChangeSeoUrlKeyForDefaultCategoryDefaultStore
		$I->fillField("input[name='url_key']", "default-simplecategory" . msq("_defaultCategoryDifferentUrlStore")); // stepKey: enterURLKeyChangeSeoUrlKeyForDefaultCategoryDefaultStore
		$I->uncheckOption("[data-index='url_key_create_redirect'] input[type='checkbox']"); // stepKey: uncheckRedirectCheckboxChangeSeoUrlKeyForDefaultCategoryDefaultStore
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryChangeSeoUrlKeyForDefaultCategoryDefaultStore
		$I->waitForPageLoad(30); // stepKey: saveCategoryChangeSeoUrlKeyForDefaultCategoryDefaultStoreWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageChangeSeoUrlKeyForDefaultCategoryDefaultStore
		$I->comment("Exiting Action Group [changeSeoUrlKeyForDefaultCategoryDefaultStore] AdminChangeSeoUrlKeyForSubCategoryWithoutRedirectActionGroup");
		$I->comment("Entering Action Group [AdminSwitchCustomStoreViewForDefaultCategory] AdminSwitchStoreViewActionGroup");
		$I->click("#store-change-button"); // stepKey: clickStoreViewSwitchDropdownAdminSwitchCustomStoreViewForDefaultCategory
		$I->waitForElementVisible("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]", 30); // stepKey: waitForStoreViewsAreVisibleAdminSwitchCustomStoreViewForDefaultCategory
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewsAreVisibleAdminSwitchCustomStoreViewForDefaultCategoryWaitForPageLoad
		$I->click("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'store" . msq("customStore") . "')]"); // stepKey: clickStoreViewByNameAdminSwitchCustomStoreViewForDefaultCategory
		$I->waitForPageLoad(30); // stepKey: clickStoreViewByNameAdminSwitchCustomStoreViewForDefaultCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalAdminSwitchCustomStoreViewForDefaultCategory
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalAdminSwitchCustomStoreViewForDefaultCategoryWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchAdminSwitchCustomStoreViewForDefaultCategory
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchAdminSwitchCustomStoreViewForDefaultCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewSwitchedAdminSwitchCustomStoreViewForDefaultCategory
		$I->scrollToTopOfPage(); // stepKey: scrollToStoreSwitcherAdminSwitchCustomStoreViewForDefaultCategory
		$I->see("store" . msq("customStore"), ".store-switcher"); // stepKey: seeNewStoreViewNameAdminSwitchCustomStoreViewForDefaultCategory
		$I->comment("Exiting Action Group [AdminSwitchCustomStoreViewForDefaultCategory] AdminSwitchStoreViewActionGroup");
		$I->comment("Entering Action Group [changeSeoUrlKeyForDefaultCategoryCustomStore] AdminChangeSeoUrlKeyForSubCategoryWithoutRedirectActionGroup");
		$I->conditionalClick("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", "div[data-index='search_engine_optimization'] .admin__fieldset-wrapper-content", false); // stepKey: openSeoSectionChangeSeoUrlKeyForDefaultCategoryCustomStore
		$I->uncheckOption("input[name='use_default[url_key]']"); // stepKey: uncheckDefaultValueChangeSeoUrlKeyForDefaultCategoryCustomStore
		$I->fillField("input[name='url_key']", "custom-simplecategory" . msq("_defaultCategoryDifferentUrlStore")); // stepKey: enterURLKeyChangeSeoUrlKeyForDefaultCategoryCustomStore
		$I->uncheckOption("[data-index='url_key_create_redirect'] input[type='checkbox']"); // stepKey: uncheckRedirectCheckboxChangeSeoUrlKeyForDefaultCategoryCustomStore
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryChangeSeoUrlKeyForDefaultCategoryCustomStore
		$I->waitForPageLoad(30); // stepKey: saveCategoryChangeSeoUrlKeyForDefaultCategoryCustomStoreWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageChangeSeoUrlKeyForDefaultCategoryCustomStore
		$I->comment("Exiting Action Group [changeSeoUrlKeyForDefaultCategoryCustomStore] AdminChangeSeoUrlKeyForSubCategoryWithoutRedirectActionGroup");
		$I->comment("Entering Action Group [navigateToCreatedSubCategory] NavigateToCreatedCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageNavigateToCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedSubCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllNavigateToCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedSubCategory
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('subCategory', 'Name', 'test') . "')]"); // stepKey: navigateToCreatedCategoryNavigateToCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategoryNavigateToCreatedSubCategoryWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerNavigateToCreatedSubCategory
		$I->comment("Exiting Action Group [navigateToCreatedSubCategory] NavigateToCreatedCategoryActionGroup");
		$I->comment("Entering Action Group [AdminSwitchDefaultStoreViewForSubCategory] AdminSwitchStoreViewActionGroup");
		$I->click("#store-change-button"); // stepKey: clickStoreViewSwitchDropdownAdminSwitchDefaultStoreViewForSubCategory
		$I->waitForElementVisible("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]", 30); // stepKey: waitForStoreViewsAreVisibleAdminSwitchDefaultStoreViewForSubCategory
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewsAreVisibleAdminSwitchDefaultStoreViewForSubCategoryWaitForPageLoad
		$I->click("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]"); // stepKey: clickStoreViewByNameAdminSwitchDefaultStoreViewForSubCategory
		$I->waitForPageLoad(30); // stepKey: clickStoreViewByNameAdminSwitchDefaultStoreViewForSubCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalAdminSwitchDefaultStoreViewForSubCategory
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalAdminSwitchDefaultStoreViewForSubCategoryWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchAdminSwitchDefaultStoreViewForSubCategory
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchAdminSwitchDefaultStoreViewForSubCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewSwitchedAdminSwitchDefaultStoreViewForSubCategory
		$I->scrollToTopOfPage(); // stepKey: scrollToStoreSwitcherAdminSwitchDefaultStoreViewForSubCategory
		$I->see("Default Store View", ".store-switcher"); // stepKey: seeNewStoreViewNameAdminSwitchDefaultStoreViewForSubCategory
		$I->comment("Exiting Action Group [AdminSwitchDefaultStoreViewForSubCategory] AdminSwitchStoreViewActionGroup");
		$I->comment("Entering Action Group [changeSeoUrlKeyForSubCategoryDefaultStore] AdminChangeSeoUrlKeyForSubCategoryWithoutRedirectActionGroup");
		$I->conditionalClick("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", "div[data-index='search_engine_optimization'] .admin__fieldset-wrapper-content", false); // stepKey: openSeoSectionChangeSeoUrlKeyForSubCategoryDefaultStore
		$I->uncheckOption("input[name='use_default[url_key]']"); // stepKey: uncheckDefaultValueChangeSeoUrlKeyForSubCategoryDefaultStore
		$I->fillField("input[name='url_key']", "default-simplesubcategory" . msq("SimpleSubCategoryDifferentUrlStore")); // stepKey: enterURLKeyChangeSeoUrlKeyForSubCategoryDefaultStore
		$I->uncheckOption("[data-index='url_key_create_redirect'] input[type='checkbox']"); // stepKey: uncheckRedirectCheckboxChangeSeoUrlKeyForSubCategoryDefaultStore
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryChangeSeoUrlKeyForSubCategoryDefaultStore
		$I->waitForPageLoad(30); // stepKey: saveCategoryChangeSeoUrlKeyForSubCategoryDefaultStoreWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageChangeSeoUrlKeyForSubCategoryDefaultStore
		$I->comment("Exiting Action Group [changeSeoUrlKeyForSubCategoryDefaultStore] AdminChangeSeoUrlKeyForSubCategoryWithoutRedirectActionGroup");
		$I->comment("Entering Action Group [AdminSwitchCustomStoreViewForSubCategory] AdminSwitchStoreViewActionGroup");
		$I->click("#store-change-button"); // stepKey: clickStoreViewSwitchDropdownAdminSwitchCustomStoreViewForSubCategory
		$I->waitForElementVisible("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]", 30); // stepKey: waitForStoreViewsAreVisibleAdminSwitchCustomStoreViewForSubCategory
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewsAreVisibleAdminSwitchCustomStoreViewForSubCategoryWaitForPageLoad
		$I->click("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'store" . msq("customStore") . "')]"); // stepKey: clickStoreViewByNameAdminSwitchCustomStoreViewForSubCategory
		$I->waitForPageLoad(30); // stepKey: clickStoreViewByNameAdminSwitchCustomStoreViewForSubCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalAdminSwitchCustomStoreViewForSubCategory
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalAdminSwitchCustomStoreViewForSubCategoryWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchAdminSwitchCustomStoreViewForSubCategory
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchAdminSwitchCustomStoreViewForSubCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewSwitchedAdminSwitchCustomStoreViewForSubCategory
		$I->scrollToTopOfPage(); // stepKey: scrollToStoreSwitcherAdminSwitchCustomStoreViewForSubCategory
		$I->see("store" . msq("customStore"), ".store-switcher"); // stepKey: seeNewStoreViewNameAdminSwitchCustomStoreViewForSubCategory
		$I->comment("Exiting Action Group [AdminSwitchCustomStoreViewForSubCategory] AdminSwitchStoreViewActionGroup");
		$I->comment("Entering Action Group [changeSeoUrlKeyForSubCategoryCustomStore] AdminChangeSeoUrlKeyForSubCategoryWithoutRedirectActionGroup");
		$I->conditionalClick("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", "div[data-index='search_engine_optimization'] .admin__fieldset-wrapper-content", false); // stepKey: openSeoSectionChangeSeoUrlKeyForSubCategoryCustomStore
		$I->uncheckOption("input[name='use_default[url_key]']"); // stepKey: uncheckDefaultValueChangeSeoUrlKeyForSubCategoryCustomStore
		$I->fillField("input[name='url_key']", "custom-simplesubcategory" . msq("SimpleSubCategoryDifferentUrlStore")); // stepKey: enterURLKeyChangeSeoUrlKeyForSubCategoryCustomStore
		$I->uncheckOption("[data-index='url_key_create_redirect'] input[type='checkbox']"); // stepKey: uncheckRedirectCheckboxChangeSeoUrlKeyForSubCategoryCustomStore
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryChangeSeoUrlKeyForSubCategoryCustomStore
		$I->waitForPageLoad(30); // stepKey: saveCategoryChangeSeoUrlKeyForSubCategoryCustomStoreWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageChangeSeoUrlKeyForSubCategoryCustomStore
		$I->comment("Exiting Action Group [changeSeoUrlKeyForSubCategoryCustomStore] AdminChangeSeoUrlKeyForSubCategoryWithoutRedirectActionGroup");
		$I->comment("Entering Action Group [validatesRewriteUrlDefaultStore] AssertStorefrontProductRewriteUrlSubCategoryActionGroup");
		$I->amOnPage("default-simplecategory" . msq("_defaultCategoryDifferentUrlStore") . "/simple-product-" . msq("SimpleProduct") . "2.html"); // stepKey: goToProductPageValidatesRewriteUrlDefaultStore
		$I->see("Simple Product " . msq("SimpleProduct"), ".base"); // stepKey: seeProductNameInStoreFrontValidatesRewriteUrlDefaultStore
		$I->comment("Exiting Action Group [validatesRewriteUrlDefaultStore] AssertStorefrontProductRewriteUrlSubCategoryActionGroup");
		$I->comment("Entering Action Group [switchStore] StorefrontSwitchStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherSwitchStore
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownSwitchStore
		$I->click("li.view-store" . msq("customStore") . ">a"); // stepKey: clickSelectStoreViewSwitchStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchStore
		$I->comment("Exiting Action Group [switchStore] StorefrontSwitchStoreViewActionGroup");
		$I->comment("Entering Action Group [validatesRewriteUrlCustomStore] AssertStorefrontProductRewriteUrlSubCategoryActionGroup");
		$I->amOnPage("custom-simplecategory" . msq("_defaultCategoryDifferentUrlStore") . "/simple-product-" . msq("SimpleProduct") . "2.html"); // stepKey: goToProductPageValidatesRewriteUrlCustomStore
		$I->see("Simple Product " . msq("SimpleProduct"), ".base"); // stepKey: seeProductNameInStoreFrontValidatesRewriteUrlCustomStore
		$I->comment("Exiting Action Group [validatesRewriteUrlCustomStore] AssertStorefrontProductRewriteUrlSubCategoryActionGroup");
	}
}
