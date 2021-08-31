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
 * @Title("MC-14297: Delete store group and save backup")
 * @Description("Test log in to Stores and Delete Store Group Test<h3>Test files</h3>app/code/Magento/Store/Test/Mftf/Test/AdminDeleteStoreGroupTest.xml<br>")
 * @TestCaseId("MC-14297")
 * @group store
 * @group mtf_migrated
 */
class AdminDeleteStoreGroupTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$setEnableBackupToYes = $I->magentoCLI("config:set system/backup/functionality_enabled 1", 60); // stepKey: setEnableBackupToYes
		$I->comment($setEnableBackupToYes);
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create custom store group");
		$I->comment("Entering Action Group [createNewCustomStoreGroup] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateNewCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateNewCustomStoreGroup
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Main Website"); // stepKey: selectWebsiteCreateNewCustomStoreGroup
		$I->fillField("#group_name", "store" . msq("customStore")); // stepKey: enterStoreGroupNameCreateNewCustomStoreGroup
		$I->fillField("#group_code", "store" . msq("customStore")); // stepKey: enterStoreGroupCodeCreateNewCustomStoreGroup
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateNewCustomStoreGroup
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateNewCustomStoreGroup
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateNewCustomStoreGroupWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateNewCustomStoreGroup
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateNewCustomStoreGroup
		$I->comment("Exiting Action Group [createNewCustomStoreGroup] AdminCreateNewStoreGroupActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$setEnableBackupToNo = $I->magentoCLI("config:set system/backup/functionality_enabled 0", 60); // stepKey: setEnableBackupToNo
		$I->comment($setEnableBackupToNo);
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
	 * @Stories({"Delete Store Group"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Store"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteStoreGroupTest(AcceptanceTester $I)
	{
		$I->comment("Delete custom store group and verify AssertStoreGroupSuccessDeleteAndBackupMessages");
		$I->comment("Entering Action Group [deleteCustomStoreGroup] DeleteCustomStoreBackupEnabledYesActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteCustomStoreGroup
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteCustomStoreGroupWaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "store" . msq("customStore")); // stepKey: fillSearchStoreGroupFieldDeleteCustomStoreGroup
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteCustomStoreGroupWaitForPageLoad
		$I->see("store" . msq("customStore"), ".col-group_title>a"); // stepKey: verifyThatCorrectStoreGroupFoundDeleteCustomStoreGroup
		$I->click(".col-group_title>a"); // stepKey: clickEditExistingStoreRowDeleteCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteCustomStoreGroup
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteCustomStoreGroupWaitForPageLoad
		$I->selectOption("#store_create_backup", "Yes"); // stepKey: setCreateDbBackupToNoDeleteCustomStoreGroup
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteCustomStoreGroupWaitForPageLoad
		$I->see("The database was backed up.", "//div[@class='message message-success success']/div"); // stepKey: seeAssertDatabaseBackedUpMessageDeleteCustomStoreGroup
		$I->see("You deleted the store.", "//div[@class='message message-success success']/div"); // stepKey: seeAssertSuccessDeleteStoreGroupMessageDeleteCustomStoreGroup
		$I->comment("Exiting Action Group [deleteCustomStoreGroup] DeleteCustomStoreBackupEnabledYesActionGroup");
		$I->comment("Verify deleted Store group is not present in grid and verify AssertStoreGroupNotInGrid message");
		$I->comment("Entering Action Group [verifyDeletedStoreGroupNotInGrid] AssertStoreNotInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageVerifyDeletedStoreGroupNotInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStorePageLoadVerifyDeletedStoreGroupNotInGrid
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterVerifyDeletedStoreGroupNotInGrid
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterVerifyDeletedStoreGroupNotInGridWaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "store" . msq("customStore")); // stepKey: fillSearchStoreGroupFieldVerifyDeletedStoreGroupNotInGrid
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonVerifyDeletedStoreGroupNotInGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonVerifyDeletedStoreGroupNotInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadVerifyDeletedStoreGroupNotInGrid
		$I->see("We couldn't find any records.", "//tr[@class='data-grid-tr-no-data even']/td[@class='empty-text']"); // stepKey: seeAssertStoreGroupNotInGridMessageVerifyDeletedStoreGroupNotInGrid
		$I->comment("Exiting Action Group [verifyDeletedStoreGroupNotInGrid] AssertStoreNotInGridActionGroup");
		$I->comment("Go to backup index page and verify AssertBackupInGrid");
		$I->comment("Entering Action Group [navigateToBackupPage] AdminBackupIndexPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/backup/index/"); // stepKey: navigateToBackupIndexPageNavigateToBackupPage
		$I->waitForPageLoad(30); // stepKey: waitForBackupIndexPageLoadNavigateToBackupPage
		$I->comment("Exiting Action Group [navigateToBackupPage] AdminBackupIndexPageOpenActionGroup");
		$I->see("WebSetupWizard", "table.data-grid td[data-column='display_name']"); // stepKey: seeBackupInGrid
		$I->comment("Delete database backup");
		$I->comment("Entering Action Group [deleteDatabaseBackup] AdminBackupDeleteActionGroup");
		$I->see("WebSetupWizard", "table.data-grid td[data-column='display_name']"); // stepKey: seeBackupInGridDeleteDatabaseBackup
		$I->click("//table//td[contains(., 'WebSetupWizard')]/parent::tr/td[@data-column='massaction']//input"); // stepKey: selectBackupRowDeleteDatabaseBackup
		$I->selectOption("#backupsGrid_massaction-select", "Delete"); // stepKey: selectDeleteActionDeleteDatabaseBackup
		$I->click("#backupsGrid_massaction button[title='Submit']"); // stepKey: clickSubmitDeleteDatabaseBackup
		$I->waitForPageLoad(30); // stepKey: waitForConfirmWindowToAppearDeleteDatabaseBackup
		$I->see("Are you sure you want to delete the selected backup(s)?", "aside.confirm .modal-content"); // stepKey: seeConfirmationModalDeleteDatabaseBackup
		$I->waitForPageLoad(30); // stepKey: waitForSubmitActionDeleteDatabaseBackup
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOkConfirmDeleteDeleteDatabaseBackup
		$I->waitForPageLoad(60); // stepKey: clickOkConfirmDeleteDeleteDatabaseBackupWaitForPageLoad
		$I->dontSee("WebSetupWizard", "table.data-grid td[data-column='display_name']"); // stepKey: dontSeeBackupInGridDeleteDatabaseBackup
		$I->comment("Exiting Action Group [deleteDatabaseBackup] AdminBackupDeleteActionGroup");
	}
}
