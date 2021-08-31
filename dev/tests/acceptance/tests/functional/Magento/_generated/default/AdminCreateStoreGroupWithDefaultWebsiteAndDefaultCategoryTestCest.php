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
 * @Title("MC-14298: Create Store Group with Default Website and Default Category")
 * @Description("Test log in to Stores and Create Store Group with Default Website and Default Category Test<h3>Test files</h3>app/code/Magento/Store/Test/Mftf/Test/AdminCreateStoreGroupWithDefaultWebsiteAndDefaultCategoryTest.xml<br>")
 * @TestCaseId("MC-14298")
 * @group store
 * @group mtf_migrated
 */
class AdminCreateStoreGroupWithDefaultWebsiteAndDefaultCategoryTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteStoreGroup] DeleteCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteStoreGroup
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreGroup
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreGroupWaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "Second Store " . msq("SecondStoreGroupUnique")); // stepKey: fillSearchStoreGroupFieldDeleteStoreGroup
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteStoreGroup
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteStoreGroupWaitForPageLoad
		$I->see("Second Store " . msq("SecondStoreGroupUnique"), ".col-group_title>a"); // stepKey: verifyThatCorrectStoreGroupFoundDeleteStoreGroup
		$I->click(".col-group_title>a"); // stepKey: clickEditExistingStoreRowDeleteStoreGroup
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteStoreGroup
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteStoreGroup
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteStoreGroupWaitForPageLoad
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteStoreGroup
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteStoreGroup
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteStoreGroupWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteStoreGroup
		$I->see("You deleted the store.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteStoreGroup
		$I->comment("Exiting Action Group [deleteStoreGroup] DeleteCustomStoreActionGroup");
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
	 * @Stories({"Create Store Group"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Store"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateStoreGroupWithDefaultWebsiteAndDefaultCategoryTest(AcceptanceTester $I)
	{
		$I->comment("Create custom store group with default website and default category and verify AssertStoreGroupSuccessSaveMessage");
		$I->comment("Entering Action Group [createNewCustomStoreGroup] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateNewCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateNewCustomStoreGroup
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Main Website"); // stepKey: selectWebsiteCreateNewCustomStoreGroup
		$I->fillField("#group_name", "Second Store " . msq("SecondStoreGroupUnique")); // stepKey: enterStoreGroupNameCreateNewCustomStoreGroup
		$I->fillField("#group_code", "second_store_" . msq("SecondStoreGroupUnique")); // stepKey: enterStoreGroupCodeCreateNewCustomStoreGroup
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateNewCustomStoreGroup
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateNewCustomStoreGroup
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateNewCustomStoreGroupWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateNewCustomStoreGroup
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateNewCustomStoreGroup
		$I->comment("Exiting Action Group [createNewCustomStoreGroup] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Search created store group(from above step) in grid and verify AssertStoreGroupInGrid");
		$I->comment("Entering Action Group [seeCreatedStoreGroupInGrid] AssertStoreGroupInGridActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageSeeCreatedStoreGroupInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStorePageLoadSeeCreatedStoreGroupInGrid
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterSeeCreatedStoreGroupInGrid
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterSeeCreatedStoreGroupInGridWaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "Second Store " . msq("SecondStoreGroupUnique")); // stepKey: fillSearchStoreGroupFieldSeeCreatedStoreGroupInGrid
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonSeeCreatedStoreGroupInGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonSeeCreatedStoreGroupInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadSeeCreatedStoreGroupInGrid
		$I->see("Second Store " . msq("SecondStoreGroupUnique"), "(//*[@id='storeGrid_table']/tbody/tr)[1]"); // stepKey: seeAssertStoreGroupInGridMessageSeeCreatedStoreGroupInGrid
		$I->comment("Exiting Action Group [seeCreatedStoreGroupInGrid] AssertStoreGroupInGridActionGroup");
		$I->comment("Go to store group form page and verify AssertStoreGroupForm and AssertStoreGroupOnStoreViewForm");
		$I->comment("Entering Action Group [seeCreatedStoreGroupForm] AssertStoreGroupFormActionGroup");
		$I->comment("Admin creates new Store group");
		$I->click(".col-group_title>a"); // stepKey: clickEditExistingStoreRowSeeCreatedStoreGroupForm
		$I->waitForPageLoad(30); // stepKey: waitTillAdminSystemStoreGroupPageSeeCreatedStoreGroupForm
		$I->seeInField("#group_website_id", "Main Website"); // stepKey: seeAssertWebsiteSeeCreatedStoreGroupForm
		$I->seeInField("#group_name", "Second Store " . msq("SecondStoreGroupUnique")); // stepKey: seeAssertStoreGroupNameSeeCreatedStoreGroupForm
		$I->seeInField("#group_code", "second_store_" . msq("SecondStoreGroupUnique")); // stepKey: seeAssertStoreGroupCodeSeeCreatedStoreGroupForm
		$I->seeInField("#group_root_category_id", "Default Category"); // stepKey: seeAssertRootCategorySeeCreatedStoreGroupForm
		$I->comment("Exiting Action Group [seeCreatedStoreGroupForm] AssertStoreGroupFormActionGroup");
	}
}
