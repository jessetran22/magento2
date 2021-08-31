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
 * @Title("MC-11011: Flat Catalog - Update Category, Include in Navigation Menu")
 * @Description("Login as admin and update flat category by enabling Include in Menu<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminUpdateFlatCategoryIncludeInNavigationTest.xml<br>")
 * @TestCaseId("MC-11011")
 * @group Catalog
 * @group mtf_migrated
 */
class AdminUpdateFlatCategoryAndIncludeInMenuTestCest
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
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "CatNotIncludeInMenu", [], []); // stepKey: createCategory
		$I->comment("Create First StoreView");
		$I->comment("Entering Action Group [createCustomStoreViewEn] CreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: amOnAdminSystemStoreViewPageCreateCustomStoreViewEn
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadCreateCustomStoreViewEn
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreGroupCreateCustomStoreViewEn
		$I->fillField("#store_name", "EN" . msq("customStoreEN")); // stepKey: fillStoreViewNameCreateCustomStoreViewEn
		$I->fillField("#store_code", "en" . msq("customStoreEN")); // stepKey: fillStoreViewCodeCreateCustomStoreViewEn
		$I->selectOption("#store_is_active", "1"); // stepKey: selectStoreViewStatusCreateCustomStoreViewEn
		$I->click("#save"); // stepKey: clickSaveStoreViewButtonCreateCustomStoreViewEn
		$I->waitForPageLoad(90); // stepKey: clickSaveStoreViewButtonCreateCustomStoreViewEnWaitForPageLoad
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForAcceptNewStoreViewCreationButtonCreateCustomStoreViewEn
		$I->conditionalClick(".action-primary.action-accept", ".action-primary.action-accept", true); // stepKey: clickAcceptNewStoreViewCreationButtonCreateCustomStoreViewEn
		$I->see("You saved the store view."); // stepKey: seeSavedMessageCreateCustomStoreViewEn
		$I->comment("Exiting Action Group [createCustomStoreViewEn] CreateStoreViewActionGroup");
		$I->comment("Create Second StoreView");
		$I->comment("Entering Action Group [createCustomStoreViewFr] CreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: amOnAdminSystemStoreViewPageCreateCustomStoreViewFr
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadCreateCustomStoreViewFr
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreGroupCreateCustomStoreViewFr
		$I->fillField("#store_name", "FR" . msq("customStoreFR")); // stepKey: fillStoreViewNameCreateCustomStoreViewFr
		$I->fillField("#store_code", "fr" . msq("customStoreFR")); // stepKey: fillStoreViewCodeCreateCustomStoreViewFr
		$I->selectOption("#store_is_active", "1"); // stepKey: selectStoreViewStatusCreateCustomStoreViewFr
		$I->click("#save"); // stepKey: clickSaveStoreViewButtonCreateCustomStoreViewFr
		$I->waitForPageLoad(90); // stepKey: clickSaveStoreViewButtonCreateCustomStoreViewFrWaitForPageLoad
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForAcceptNewStoreViewCreationButtonCreateCustomStoreViewFr
		$I->conditionalClick(".action-primary.action-accept", ".action-primary.action-accept", true); // stepKey: clickAcceptNewStoreViewCreationButtonCreateCustomStoreViewFr
		$I->see("You saved the store view."); // stepKey: seeSavedMessageCreateCustomStoreViewFr
		$I->comment("Exiting Action Group [createCustomStoreViewFr] CreateStoreViewActionGroup");
		$I->comment("Enable Flat Catalog Category");
		$setFlatCatalogCategory = $I->magentoCLI("config:set catalog/frontend/flat_catalog_category 1", 60); // stepKey: setFlatCatalogCategory
		$I->comment($setFlatCatalogCategory);
		$I->comment("Open Index Management Page and Select Index mode \"Update by Schedule\"");
		$setIndexerMode = $I->magentoCLI("indexer:set-mode", 60, "schedule"); // stepKey: setIndexerMode
		$I->comment($setIndexerMode);
		$I->comment("Reindex invalidated indices");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [deleteStoreViewEn] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreViewEn
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreViewEn
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreViewEn
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreViewEnWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "EN" . msq("customStoreEN")); // stepKey: fillStoreViewFilterFieldDeleteStoreViewEn
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreViewEnWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreViewEn
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreViewEnWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreViewEn
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreViewEn
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreViewEn
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreViewEnWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreViewEn
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewEn
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewEnWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreViewEn
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreViewEn
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreViewEnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreViewEn
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreViewEn
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreViewEn
		$I->comment("Exiting Action Group [deleteStoreViewEn] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [deleteStoreViewFr] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreViewFr
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreViewFr
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreViewFr
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreViewFrWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "FR" . msq("customStoreFR")); // stepKey: fillStoreViewFilterFieldDeleteStoreViewFr
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreViewFrWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreViewFr
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreViewFrWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreViewFr
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreViewFr
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreViewFr
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreViewFrWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreViewFr
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewFr
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewFrWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreViewFr
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreViewFr
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreViewFrWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreViewFr
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreViewFr
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreViewFr
		$I->comment("Exiting Action Group [deleteStoreViewFr] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$setFlatCatalogCategory = $I->magentoCLI("config:set catalog/frontend/flat_catalog_category 0 ", 60); // stepKey: setFlatCatalogCategory
		$I->comment($setFlatCatalogCategory);
		$setIndexersMode = $I->magentoCLI("indexer:set-mode", 60, "realtime"); // stepKey: setIndexersMode
		$I->comment($setIndexersMode);
		$reindexInvalidatedIndicesAgain = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndicesAgain
		$I->comment($reindexInvalidatedIndicesAgain);
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
	 * @Stories({"Update category"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateFlatCategoryAndIncludeInMenuTest(AcceptanceTester $I)
	{
		$I->comment("Verify Category is not listed in navigation menu");
		$I->amOnPage("/notinclemenu" . msq("CatNotIncludeInMenu") . ".html"); // stepKey: openCategoryPage
		$I->waitForPageLoad(60); // stepKey: waitForPageToBeLoaded
		$I->dontSee("//nav//a[span[contains(., 'NotInclMenu" . msq("CatNotIncludeInMenu") . "')]]"); // stepKey: dontSeeCategoryOnNavigation
		$I->waitForPageLoad(30); // stepKey: dontSeeCategoryOnNavigationWaitForPageLoad
		$I->comment("Select created category and enable Include In Menu option");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [clickOnExpandTree] AdminExpandCategoryTreeActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeClickOnExpandTree
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadClickOnExpandTree
		$I->comment("Exiting Action Group [clickOnExpandTree] AdminExpandCategoryTreeActionGroup");
		$I->click("//a/span[contains(text(), 'NotInclMenu" . msq("CatNotIncludeInMenu") . "')]"); // stepKey: selectCreatedCategory
		$I->waitForPageLoad(30); // stepKey: selectCreatedCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoad
		$I->click("input[name='include_in_menu']+label"); // stepKey: enableIncludeInMenuOption
		$I->comment("Entering Action Group [saveSubCategory] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveSubCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveSubCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveSubCategory
		$I->comment("Exiting Action Group [saveSubCategory] AdminSaveCategoryActionGroup");
		$I->seeElement(".message-success"); // stepKey: seeSuccessMessage
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, "catalog_category_flat"); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [openIndexManagementPage] AdminOpenIndexManagementPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/indexer/indexer/list/"); // stepKey: openIndexManagementPageOpenIndexManagementPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenIndexManagementPage
		$I->comment("Exiting Action Group [openIndexManagementPage] AdminOpenIndexManagementPageActionGroup");
		$I->see("Ready", "//tr[descendant::td[contains(., 'Category Flat Data')]]//*[contains(@class, 'col-indexer_status')]/span"); // stepKey: seeIndexStatus
		$I->comment("Verify Category In Store Front");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openCategoryPage1
		$I->waitForPageLoad(30); // stepKey: waitForCategoryStoreFrontPageToLoad
		$I->comment("Verify category is visible in First Store View");
		$I->click("#switcher-language-trigger"); // stepKey: selectStoreSwitcher
		$I->click("//li[contains(.,'EN" . msq("customStoreEN") . "')]//a"); // stepKey: selectForstStoreView
		$I->waitForPageLoad(30); // stepKey: waitForFirstStoreView
		$I->seeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: seeCategoryOnNavigation
		$I->waitForPageLoad(30); // stepKey: seeCategoryOnNavigationWaitForPageLoad
		$I->comment("Verify category is visible in Second Store View");
		$I->click("#switcher-language-trigger"); // stepKey: selectStoreSwitcher1
		$I->click("//li[contains(.,'FR" . msq("customStoreFR") . "')]//a"); // stepKey: selectSecondStoreView
		$I->waitForPageLoad(30); // stepKey: waitForSecondstoreView
		$I->seeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: seeCategoryOnNavigation1
		$I->waitForPageLoad(30); // stepKey: seeCategoryOnNavigation1WaitForPageLoad
	}
}
