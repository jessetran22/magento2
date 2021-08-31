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
 * @Title("MC-14303: Delete Store View and Save Backup")
 * @Description("Test log in to Stores and Delete Store View<h3>Test files</h3>app/code/Magento/Store/Test/Mftf/Test/AdminDeleteStoreViewTest.xml<br>")
 * @TestCaseId("MC-14303")
 * @group store
 * @group mtf_migrated
 */
class AdminDeleteStoreViewTestCest
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
		$I->comment("Create custom store view");
		$I->comment("Entering Action Group [createNewStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateNewStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateNewStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateNewStoreView
		$I->fillField("#store_name", "storeView" . msq("storeViewData")); // stepKey: enterStoreViewNameCreateNewStoreView
		$I->fillField("#store_code", "storeView" . msq("storeViewData")); // stepKey: enterStoreViewCodeCreateNewStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateNewStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateNewStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateNewStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateNewStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateNewStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateNewStoreView
		$I->comment("Exiting Action Group [createNewStoreView] AdminCreateStoreViewActionGroup");
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
	 * @Stories({"Delete Store View"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Store"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteStoreViewTest(AcceptanceTester $I)
	{
		$I->comment("Delete custom store view and verify AssertStoreSuccessDeleteMessage And BackupMessage");
		$I->comment("Entering Action Group [deleteCustomStoreView] DeleteCustomStoreViewBackupEnabledYesActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteCustomStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteCustomStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "storeView" . msq("storeViewData")); // stepKey: fillSearchStoreViewFieldDeleteCustomStoreView
		$I->waitForPageLoad(90); // stepKey: fillSearchStoreViewFieldDeleteCustomStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteCustomStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickEditExistingStoreViewRowDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteCustomStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewButtonOnEditStorePageDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewButtonOnEditStorePageDeleteCustomStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "Yes"); // stepKey: setCreateDbBackupToYesDeleteCustomStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewButtonOnDeleteStorePageDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewButtonOnDeleteStorePageDeleteCustomStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteCustomStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreViewDeleteDeleteCustomStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreViewDeleteDeleteCustomStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteCustomStoreView
		$I->see("The database was backed up.", "//div[@class='message message-success success']/div"); // stepKey: seeAssertDatabaseBackedUpMessageDeleteCustomStoreView
		$I->see("You deleted the store view.", "//div[@class='message message-success success']/div"); // stepKey: seeAssertSuccessDeleteStoreViewMessageDeleteCustomStoreView
		$I->comment("Exiting Action Group [deleteCustomStoreView] DeleteCustomStoreViewBackupEnabledYesActionGroup");
		$I->comment("Verify deleted store view not present in grid and verify AssertStoreNotInGrid Message");
		$I->comment("Entering Action Group [verifyDeletedStoreViewNotInGrid] AssertStoreViewNotInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageVerifyDeletedStoreViewNotInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStorePageLoadVerifyDeletedStoreViewNotInGrid
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterVerifyDeletedStoreViewNotInGrid
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterVerifyDeletedStoreViewNotInGridWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "storeView" . msq("storeViewData")); // stepKey: fillSearchStoreViewFieldVerifyDeletedStoreViewNotInGrid
		$I->waitForPageLoad(90); // stepKey: fillSearchStoreViewFieldVerifyDeletedStoreViewNotInGridWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonVerifyDeletedStoreViewNotInGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonVerifyDeletedStoreViewNotInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadVerifyDeletedStoreViewNotInGrid
		$I->see("We couldn't find any records.", "//tr[@class='data-grid-tr-no-data even']/td[@class='empty-text']"); // stepKey: seeAssertStoreViewNotInGridMessageVerifyDeletedStoreViewNotInGrid
		$I->comment("Exiting Action Group [verifyDeletedStoreViewNotInGrid] AssertStoreViewNotInGridActionGroup");
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
		$I->comment("Go to storefront and verify AssertStoreNotOnFrontend");
		$I->comment("Entering Action Group [goToStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStorefrontPage
		$I->comment("Exiting Action Group [goToStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->dontSee("//li[contains(.,'storeView" . msq("storeViewData") . "')]//a"); // stepKey: dontSeeAssertStoreViewNameOnStorefront
	}
}
