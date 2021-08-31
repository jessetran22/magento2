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
 * @Title("MAGETWO-94176: Create and delete backups")
 * @Description("An admin user can create a backup of each type and delete each backup.<h3>Test files</h3>app/code/Magento/Backup/Test/Mftf/Test/AdminCreateAndDeleteBackupsTest.xml<br>")
 * @TestCaseId("MAGETWO-94176")
 * @group backup
 */
class AdminCreateAndDeleteBackupsTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$setEnableBackup = $I->magentoCLI("config:set system/backup/functionality_enabled 1", 60); // stepKey: setEnableBackup
		$I->comment($setEnableBackup);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$setDisableBackup = $I->magentoCLI("config:set system/backup/functionality_enabled 0", 60); // stepKey: setDisableBackup
		$I->comment($setDisableBackup);
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
	 * @Features({"Backup"})
	 * @Stories({"Create and delete backups"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateAndDeleteBackupsTest(AcceptanceTester $I)
	{
		$I->comment("Login to admin area");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Go to backup index page");
		$I->comment("Entering Action Group [navigateToBackupPage] AdminBackupIndexPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/backup/index/"); // stepKey: navigateToBackupIndexPageNavigateToBackupPage
		$I->waitForPageLoad(30); // stepKey: waitForBackupIndexPageLoadNavigateToBackupPage
		$I->comment("Exiting Action Group [navigateToBackupPage] AdminBackupIndexPageOpenActionGroup");
		$I->comment("Create system backup");
		$I->comment("Entering Action Group [createSystemBackup] CreateSystemBackupActionGroup");
		$I->click("button[data-ui-id*='createsnapshotbutton']"); // stepKey: clickCreateBackupButtonCreateSystemBackup
		$I->waitForElementVisible("input[name='backup_name']", 30); // stepKey: waitForFormCreateSystemBackup
		$I->fillField("input[name='backup_name']", "systemBackup" . msq("SystemBackup")); // stepKey: fillBackupNameCreateSystemBackup
		$I->click(".modal-header button.primary"); // stepKey: clickOkCreateSystemBackup
		$I->waitForElementNotVisible(".loading-mask", 300); // stepKey: waitForBackupProcessCreateSystemBackup
		$I->see("You created the system backup.", "#messages div.message-success"); // stepKey: seeSuccessMessageCreateSystemBackup
		$I->see("systemBackup" . msq("SystemBackup"), "table.data-grid td[data-column='display_name']"); // stepKey: seeBackupInGridCreateSystemBackup
		$I->see("System", "//table//td[contains(., 'systemBackup" . msq("SystemBackup") . "')]/parent::tr/td[@data-column='type']"); // stepKey: seeBackupTypeCreateSystemBackup
		$I->comment("Exiting Action Group [createSystemBackup] CreateSystemBackupActionGroup");
		$I->comment("Create database/media backup");
		$I->comment("Entering Action Group [createMediaBackup] CreateMediaBackupActionGroup");
		$I->click("button[data-ui-id*='createmediabackupbutton']"); // stepKey: clickCreateBackupButtonCreateMediaBackup
		$I->waitForElementVisible("input[name='backup_name']", 30); // stepKey: waitForFormCreateMediaBackup
		$I->fillField("input[name='backup_name']", "mediaBackup" . msq("MediaBackup")); // stepKey: fillBackupNameCreateMediaBackup
		$I->click(".modal-header button.primary"); // stepKey: clickOkCreateMediaBackup
		$I->waitForPageLoad(120); // stepKey: waitForBackupProcessCreateMediaBackup
		$I->see("You created the database and media backup.", "#messages div.message-success"); // stepKey: seeSuccessMessageCreateMediaBackup
		$I->see("mediaBackup" . msq("MediaBackup"), "table.data-grid td[data-column='display_name']"); // stepKey: seeBackupInGridCreateMediaBackup
		$I->see("Database and Media", "//table//td[contains(., 'mediaBackup" . msq("MediaBackup") . "')]/parent::tr/td[@data-column='type']"); // stepKey: seeBackupTypeCreateMediaBackup
		$I->comment("Exiting Action Group [createMediaBackup] CreateMediaBackupActionGroup");
		$I->comment("Create database backup");
		$I->comment("Entering Action Group [createDatabaseBackup] CreateDatabaseBackupActionGroup");
		$I->click("button.database-backup[data-ui-id*='createbutton']"); // stepKey: clickCreateBackupButtonCreateDatabaseBackup
		$I->waitForElementVisible("input[name='backup_name']", 30); // stepKey: waitForFormCreateDatabaseBackup
		$I->fillField("input[name='backup_name']", "databaseBackup" . msq("DatabaseBackup")); // stepKey: fillBackupNameCreateDatabaseBackup
		$I->click(".modal-header button.primary"); // stepKey: clickOkCreateDatabaseBackup
		$I->waitForPageLoad(120); // stepKey: waitForBackupProcessCreateDatabaseBackup
		$I->see("You created the database backup.", "#messages div.message-success"); // stepKey: seeSuccessMessageCreateDatabaseBackup
		$I->see("databaseBackup" . msq("DatabaseBackup"), "table.data-grid td[data-column='display_name']"); // stepKey: seeBackupInGridCreateDatabaseBackup
		$I->see("Database", "//table//td[contains(., 'databaseBackup" . msq("DatabaseBackup") . "')]/parent::tr/td[@data-column='type']"); // stepKey: seeBackupTypeCreateDatabaseBackup
		$I->comment("Exiting Action Group [createDatabaseBackup] CreateDatabaseBackupActionGroup");
		$I->comment("Delete system backup");
		$I->comment("Entering Action Group [deleteSystemBackup] AdminBackupDeleteActionGroup");
		$I->see("systemBackup" . msq("SystemBackup"), "table.data-grid td[data-column='display_name']"); // stepKey: seeBackupInGridDeleteSystemBackup
		$I->click("//table//td[contains(., 'systemBackup" . msq("SystemBackup") . "')]/parent::tr/td[@data-column='massaction']//input"); // stepKey: selectBackupRowDeleteSystemBackup
		$I->selectOption("#backupsGrid_massaction-select", "Delete"); // stepKey: selectDeleteActionDeleteSystemBackup
		$I->click("#backupsGrid_massaction button[title='Submit']"); // stepKey: clickSubmitDeleteSystemBackup
		$I->waitForPageLoad(30); // stepKey: waitForConfirmWindowToAppearDeleteSystemBackup
		$I->see("Are you sure you want to delete the selected backup(s)?", "aside.confirm .modal-content"); // stepKey: seeConfirmationModalDeleteSystemBackup
		$I->waitForPageLoad(30); // stepKey: waitForSubmitActionDeleteSystemBackup
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOkConfirmDeleteDeleteSystemBackup
		$I->waitForPageLoad(60); // stepKey: clickOkConfirmDeleteDeleteSystemBackupWaitForPageLoad
		$I->dontSee("systemBackup" . msq("SystemBackup"), "table.data-grid td[data-column='display_name']"); // stepKey: dontSeeBackupInGridDeleteSystemBackup
		$I->comment("Exiting Action Group [deleteSystemBackup] AdminBackupDeleteActionGroup");
		$I->comment("Delete database/media backup");
		$I->comment("Entering Action Group [deleteMediaBackup] AdminBackupDeleteActionGroup");
		$I->see("mediaBackup" . msq("MediaBackup"), "table.data-grid td[data-column='display_name']"); // stepKey: seeBackupInGridDeleteMediaBackup
		$I->click("//table//td[contains(., 'mediaBackup" . msq("MediaBackup") . "')]/parent::tr/td[@data-column='massaction']//input"); // stepKey: selectBackupRowDeleteMediaBackup
		$I->selectOption("#backupsGrid_massaction-select", "Delete"); // stepKey: selectDeleteActionDeleteMediaBackup
		$I->click("#backupsGrid_massaction button[title='Submit']"); // stepKey: clickSubmitDeleteMediaBackup
		$I->waitForPageLoad(30); // stepKey: waitForConfirmWindowToAppearDeleteMediaBackup
		$I->see("Are you sure you want to delete the selected backup(s)?", "aside.confirm .modal-content"); // stepKey: seeConfirmationModalDeleteMediaBackup
		$I->waitForPageLoad(30); // stepKey: waitForSubmitActionDeleteMediaBackup
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOkConfirmDeleteDeleteMediaBackup
		$I->waitForPageLoad(60); // stepKey: clickOkConfirmDeleteDeleteMediaBackupWaitForPageLoad
		$I->dontSee("mediaBackup" . msq("MediaBackup"), "table.data-grid td[data-column='display_name']"); // stepKey: dontSeeBackupInGridDeleteMediaBackup
		$I->comment("Exiting Action Group [deleteMediaBackup] AdminBackupDeleteActionGroup");
		$I->comment("Delete database backup");
		$I->comment("Entering Action Group [deleteDatabaseBackup] AdminBackupDeleteActionGroup");
		$I->see("databaseBackup" . msq("DatabaseBackup"), "table.data-grid td[data-column='display_name']"); // stepKey: seeBackupInGridDeleteDatabaseBackup
		$I->click("//table//td[contains(., 'databaseBackup" . msq("DatabaseBackup") . "')]/parent::tr/td[@data-column='massaction']//input"); // stepKey: selectBackupRowDeleteDatabaseBackup
		$I->selectOption("#backupsGrid_massaction-select", "Delete"); // stepKey: selectDeleteActionDeleteDatabaseBackup
		$I->click("#backupsGrid_massaction button[title='Submit']"); // stepKey: clickSubmitDeleteDatabaseBackup
		$I->waitForPageLoad(30); // stepKey: waitForConfirmWindowToAppearDeleteDatabaseBackup
		$I->see("Are you sure you want to delete the selected backup(s)?", "aside.confirm .modal-content"); // stepKey: seeConfirmationModalDeleteDatabaseBackup
		$I->waitForPageLoad(30); // stepKey: waitForSubmitActionDeleteDatabaseBackup
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOkConfirmDeleteDeleteDatabaseBackup
		$I->waitForPageLoad(60); // stepKey: clickOkConfirmDeleteDeleteDatabaseBackupWaitForPageLoad
		$I->dontSee("databaseBackup" . msq("DatabaseBackup"), "table.data-grid td[data-column='display_name']"); // stepKey: dontSeeBackupInGridDeleteDatabaseBackup
		$I->comment("Exiting Action Group [deleteDatabaseBackup] AdminBackupDeleteActionGroup");
	}
}
