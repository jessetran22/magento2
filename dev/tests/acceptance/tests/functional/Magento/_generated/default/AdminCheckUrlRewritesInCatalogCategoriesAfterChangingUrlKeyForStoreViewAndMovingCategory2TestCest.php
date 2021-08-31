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
 * @Title("MC-25622: Check url rewrites in catalog categories after changing url key")
 * @Description("Check url rewrites in catalog categories after changing url key for store view and moving category<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminCheckUrlRewritesInCatalogCategoriesAfterChangingUrlKeyForStoreViewAndMovingCategory2Test.xml<br>")
 * @TestCaseId("MC-25622")
 * @group catalog
 * @group url_rewrite
 * @group mtf_migrated
 */
class AdminCheckUrlRewritesInCatalogCategoriesAfterChangingUrlKeyForStoreViewAndMovingCategory2TestCest
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
		$I->comment("Create two sub-categories in default category with simple products");
		$I->createEntity("createFirstCategory", "hook", "_defaultCategory", [], []); // stepKey: createFirstCategory
		$I->createEntity("createFirstSimpleProduct", "hook", "_defaultProduct", ["createFirstCategory"], []); // stepKey: createFirstSimpleProduct
		$I->createEntity("createSecondCategory", "hook", "_defaultCategory", [], []); // stepKey: createSecondCategory
		$I->createEntity("createSecondSimpleProduct", "hook", "_defaultProduct", ["createSecondCategory"], []); // stepKey: createSecondSimpleProduct
		$I->comment("Log in to backend");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create additional Store View in Main Website Store");
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
		$I->comment("Entering Action Group [reindexAll] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindexAll = $I->magentoCLI("indexer:reindex", 60, "catalog_category_product"); // stepKey: reindexSpecifiedIndexersReindexAll
		$I->comment($reindexSpecifiedIndexersReindexAll);
		$I->comment("Exiting Action Group [reindexAll] CliIndexerReindexActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createFirstCategory", "hook"); // stepKey: deleteFirstCategory
		$I->deleteEntity("createSecondCategory", "hook"); // stepKey: deleteSecondCategory
		$I->deleteEntity("createFirstSimpleProduct", "hook"); // stepKey: deleteFirstSimpleProduct
		$I->deleteEntity("createSecondSimpleProduct", "hook"); // stepKey: deleteSecondSimpleProduct
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
		$I->comment("Entering Action Group [clearWebsitesGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearWebsitesGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearWebsitesGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearWebsitesGridFilters] ClearFiltersAdminDataGridActionGroup");
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
	 * @Stories({"Update url rewrites"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckUrlRewritesInCatalogCategoriesAfterChangingUrlKeyForStoreViewAndMovingCategory2Test(AcceptanceTester $I)
	{
		$I->comment("On the categories editing page change store view to created additional view");
		$I->comment("Entering Action Group [openFirstCategoryAndSwitchToCustomStoreView] SwitchCategoryStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageOpenFirstCategoryAndSwitchToCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1OpenFirstCategoryAndSwitchToCustomStoreView
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createFirstCategory', 'name', 'test') . "')]"); // stepKey: navigateToCreatedCategoryOpenFirstCategoryAndSwitchToCustomStoreView
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategoryOpenFirstCategoryAndSwitchToCustomStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenFirstCategoryAndSwitchToCustomStoreView
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerOpenFirstCategoryAndSwitchToCustomStoreView
		$I->scrollToTopOfPage(); // stepKey: scrollToToggleOpenFirstCategoryAndSwitchToCustomStoreView
		$I->click("#store-change-button"); // stepKey: openStoreViewDropDownOpenFirstCategoryAndSwitchToCustomStoreView
		$I->click("//div[contains(@class, 'store-switcher')]//a[normalize-space()='store" . msq("customStore") . "']"); // stepKey: selectStoreViewOpenFirstCategoryAndSwitchToCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3OpenFirstCategoryAndSwitchToCustomStoreView
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinner2OpenFirstCategoryAndSwitchToCustomStoreView
		$I->click(".modal-popup.confirm._show .action-accept"); // stepKey: selectStoreViewAcceptOpenFirstCategoryAndSwitchToCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewChangeLoadOpenFirstCategoryAndSwitchToCustomStoreView
		$I->comment("Exiting Action Group [openFirstCategoryAndSwitchToCustomStoreView] SwitchCategoryStoreViewActionGroup");
		$I->comment("Change url key for category for first category; save");
		$I->comment("Entering Action Group [changeFirstCategoryUrlKey] ChangeSeoUrlKeyForSubCategoryActionGroup");
		$I->conditionalClick("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", "div[data-index='search_engine_optimization'] .admin__fieldset-wrapper-content", false); // stepKey: openSeoSectionChangeFirstCategoryUrlKey
		$I->uncheckOption("input[name='use_default[url_key]']"); // stepKey: uncheckDefaultValueChangeFirstCategoryUrlKey
		$I->fillField("input[name='url_key']", "simplerootsubcategory" . msq("SimpleRootSubCategory")); // stepKey: enterURLKeyChangeFirstCategoryUrlKey
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryChangeFirstCategoryUrlKey
		$I->waitForPageLoad(30); // stepKey: saveCategoryChangeFirstCategoryUrlKeyWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageChangeFirstCategoryUrlKey
		$I->comment("Exiting Action Group [changeFirstCategoryUrlKey] ChangeSeoUrlKeyForSubCategoryActionGroup");
		$I->comment("Change store view to \"All store views\" for first category");
		$I->comment("Entering Action Group [switchToAllStoreViews] SwitchCategoryToAllStoreViewActionGroup");
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createFirstCategory', 'name', 'test') . "')]"); // stepKey: navigateToCreatedCategorySwitchToAllStoreViews
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategorySwitchToAllStoreViewsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1SwitchToAllStoreViews
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinner1SwitchToAllStoreViews
		$I->scrollToTopOfPage(); // stepKey: scrollToToggleSwitchToAllStoreViews
		$I->click("#store-change-button"); // stepKey: openStoreViewDropDownSwitchToAllStoreViews
		$I->click(".store-switcher .store-switcher-all"); // stepKey: clickStoreViewByNameSwitchToAllStoreViews
		$I->waitForPageLoad(30); // stepKey: clickStoreViewByNameSwitchToAllStoreViewsWaitForPageLoad
		$I->see("All Store Views", ".store-switcher"); // stepKey: seeAllStoreViewSwitchToAllStoreViews
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2SwitchToAllStoreViews
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinner2SwitchToAllStoreViews
		$I->click(".modal-popup.confirm._show .action-accept"); // stepKey: selectStoreViewAcceptSwitchToAllStoreViews
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewChangeLoadSwitchToAllStoreViews
		$I->comment("Exiting Action Group [switchToAllStoreViews] SwitchCategoryToAllStoreViewActionGroup");
		$I->comment("Move first category inside second category");
		$I->comment("Entering Action Group [moveFirstCategoryInsideSecondCategory] MoveCategoryActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllCategoriesTreeMoveFirstCategoryInsideSecondCategory
		$I->waitForAjaxLoad(30); // stepKey: waitForCategoriesExpandMoveFirstCategoryInsideSecondCategory
		$I->dragAndDrop("//a/span[contains(text(), '" . $I->retrieveEntityField('createFirstCategory', 'name', 'test') . "')]", "//a/span[contains(text(), '" . $I->retrieveEntityField('createSecondCategory', 'name', 'test') . "')]"); // stepKey: moveCategoryMoveFirstCategoryInsideSecondCategory
		$I->waitForPageLoad(30); // stepKey: moveCategoryMoveFirstCategoryInsideSecondCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForWarningMessageVisibleMoveFirstCategoryInsideSecondCategory
		$I->see("This operation can take a long time", "aside.confirm div.modal-content"); // stepKey: seeWarningMessageMoveFirstCategoryInsideSecondCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: clickOkButtonOnWarningPopupMoveFirstCategoryInsideSecondCategory
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageReloadMoveFirstCategoryInsideSecondCategory
		$I->comment("Exiting Action Group [moveFirstCategoryInsideSecondCategory] MoveCategoryActionGroup");
		$I->comment("Open first category storefront page");
		$I->amOnPage($I->retrieveEntityField('createSecondCategory', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createFirstCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openFirstCategoryStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForFirstCategoryStorefrontPageLoad
		$I->see($I->retrieveEntityField('createFirstSimpleProduct', 'name', 'test'), "#maincontent .column.main"); // stepKey: seeFirstProductInCategory
		$I->comment("Switch to custom store view");
		$I->comment("Entering Action Group [switchToCustomStoreView] StorefrontSwitchStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherSwitchToCustomStoreView
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownSwitchToCustomStoreView
		$I->click("li.view-store" . msq("customStore") . ">a"); // stepKey: clickSelectStoreViewSwitchToCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchToCustomStoreView
		$I->comment("Exiting Action Group [switchToCustomStoreView] StorefrontSwitchStoreViewActionGroup");
		$I->comment("Assert category url with custom store view");
		$I->seeInCurrentUrl("simplerootsubcategory" . msq("SimpleRootSubCategory") . ".html"); // stepKey: seeUpdatedUrlKey
		$I->see($I->retrieveEntityField('createFirstSimpleProduct', 'name', 'test'), "#maincontent .column.main"); // stepKey: seeFirstProductInCategoryAgain
	}
}
