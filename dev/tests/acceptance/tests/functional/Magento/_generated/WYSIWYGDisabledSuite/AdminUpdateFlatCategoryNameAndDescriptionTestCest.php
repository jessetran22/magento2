<?php
namespace Magento\AcceptanceTest\_WYSIWYGDisabledSuite\Backend;

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
 * @Title("MC-11010: Flat Catalog - Update Category Name and Description")
 * @Description("Login as admin and update flat category name and description<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminUpdateFlatCategoryNameAndDescriptionTest.xml<br>")
 * @TestCaseId("MC-11010")
 * @group Catalog
 * @group mtf_migrated
 * @group WYSIWYGDisabled
 */
class AdminUpdateFlatCategoryNameAndDescriptionTestCest
{
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
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
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$setFlatCatalogCategory = $I->magentoCLI("config:set catalog/frontend/flat_catalog_category 0 ", 60); // stepKey: setFlatCatalogCategory
		$I->comment($setFlatCatalogCategory);
		$setIndexerMode = $I->magentoCLI("indexer:set-mode", 60, "realtime"); // stepKey: setIndexerMode
		$I->comment($setIndexerMode);
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
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
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateFlatCategoryNameAndDescriptionTest(AcceptanceTester $I)
	{
		$I->comment("Select Created Category");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [clickOnExpandTree] AdminExpandCategoryTreeActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeClickOnExpandTree
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadClickOnExpandTree
		$I->comment("Exiting Action Group [clickOnExpandTree] AdminExpandCategoryTreeActionGroup");
		$I->click("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: selectCreatedCategory
		$I->waitForPageLoad(30); // stepKey: selectCreatedCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoaded
		$I->comment("Update Category Name and Description");
		$I->fillField("input[name='name']", "SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: addSubCategoryName
		$I->scrollTo("div[data-index='content']", 0, -80); // stepKey: scrollToContent
		$I->waitForPageLoad(30); // stepKey: scrollToContentWaitForPageLoad
		$I->click("div[data-index='content']"); // stepKey: selectContent
		$I->waitForPageLoad(30); // stepKey: selectContentWaitForPageLoad
		$I->fillField("//*[@name='description']", "Updated category Description Fields"); // stepKey: fillUpdatedDescription
		$I->comment("Entering Action Group [saveSubCategory] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveSubCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveSubCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveSubCategory
		$I->comment("Exiting Action Group [saveSubCategory] AdminSaveCategoryActionGroup");
		$I->seeElement(".message-success"); // stepKey: seeSuccessMessage
		$I->comment("Run full reindex and clear caches");
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, "catalog_category_flat"); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [openIndexManagementPage] AdminOpenIndexManagementPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/indexer/indexer/list/"); // stepKey: openIndexManagementPageOpenIndexManagementPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenIndexManagementPage
		$I->comment("Exiting Action Group [openIndexManagementPage] AdminOpenIndexManagementPageActionGroup");
		$I->see("READY", "//tr[descendant::td[contains(., 'Category Flat Data')]]//*[contains(@class, 'col-indexer_status')]/span"); // stepKey: seeIndexStatus
		$I->comment("Verify Category In Store Front");
		$I->amOnPage("simplesubcategory" . msq("SimpleSubCategory") . ".html"); // stepKey: goToStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToBeLoaded
		$I->comment("Verify category is visible in First Store View");
		$I->click("#switcher-language-trigger"); // stepKey: selectStoreSwitcher
		$I->click("//li[contains(.,'EN" . msq("customStoreEN") . "')]//a"); // stepKey: selectFirstStoreView
		$I->waitForPageLoad(30); // stepKey: waitForFirstStoreView
		$I->seeElement("//nav//a[span[contains(., 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]]"); // stepKey: seeCategoryOnNavigation
		$I->waitForPageLoad(30); // stepKey: seeCategoryOnNavigationWaitForPageLoad
		$I->comment("Verify  category is visible in Second Store View");
		$I->click("#switcher-language-trigger"); // stepKey: selectStoreSwitcher1
		$I->click("//li[contains(.,'FR" . msq("customStoreFR") . "')]//a"); // stepKey: selectSecondStoreView
		$I->waitForPageLoad(30); // stepKey: waitForSecondStoreView
		$I->seeElement("//nav//a[span[contains(., 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]]"); // stepKey: seeCategoryOnNavigation1
		$I->waitForPageLoad(30); // stepKey: seeCategoryOnNavigation1WaitForPageLoad
		$I->comment("Verify Updated  Category Name and description on Category Page");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage1] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage1
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage1
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage1] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [clickOnExpandTree1] AdminExpandCategoryTreeActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeClickOnExpandTree1
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadClickOnExpandTree1
		$I->comment("Exiting Action Group [clickOnExpandTree1] AdminExpandCategoryTreeActionGroup");
		$I->click("//a/span[contains(text(), 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]"); // stepKey: selectUpdatedCategory
		$I->waitForPageLoad(30); // stepKey: selectUpdatedCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForUpdatedCategoryPageToLoad
		$I->seeInField("input[name='name']", "SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: seeUpdatedSubCategoryName
		$I->scrollTo("div[data-index='content']", 0, -80); // stepKey: scrollToContent1
		$I->waitForPageLoad(30); // stepKey: scrollToContent1WaitForPageLoad
		$I->click("div[data-index='content']"); // stepKey: selectContent1
		$I->waitForPageLoad(30); // stepKey: selectContent1WaitForPageLoad
		$I->seeInField("//*[@name='description']", "Updated category Description Fields"); // stepKey: seeUpdatedDescription
	}
}
