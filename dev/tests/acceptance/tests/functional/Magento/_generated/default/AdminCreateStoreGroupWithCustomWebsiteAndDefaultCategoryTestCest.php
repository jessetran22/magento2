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
 * @Title("MC-14300: Create Store Group with Custom Website and Default Category")
 * @Description("Test log in to Stores and Create Store Group with Custom Website and Default Category Test<h3>Test files</h3>app/code/Magento/Store/Test/Mftf/Test/AdminCreateStoreGroupWithCustomWebsiteAndDefaultCategoryTest.xml<br>")
 * @TestCaseId("MC-14300")
 * @group store
 * @group mtf_migrated
 */
class AdminCreateStoreGroupWithCustomWebsiteAndDefaultCategoryTestCest
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
		$I->comment("Create website");
		$I->comment("Entering Action Group [createWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "Second Website" . msq("customWebsite")); // stepKey: enterWebsiteNameCreateWebsite
		$I->fillField("#website_code", "second_website" . msq("customWebsite")); // stepKey: enterWebsiteCodeCreateWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteCreateWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteCreateWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadCreateWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageCreateWebsite
		$I->comment("Exiting Action Group [createWebsite] AdminCreateWebsiteActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "Second Website" . msq("customWebsite")); // stepKey: fillSearchWebsiteFieldDeleteWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteWebsiteWaitForPageLoad
		$I->see("Second Website" . msq("customWebsite"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteWebsite
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingStoreRowDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteStoreGroupSectionLoadDeleteWebsite
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonDeleteWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadDeleteWebsite
		$I->see("You deleted the website."); // stepKey: seeSavedMessageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilter2DeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilter2DeleteWebsiteWaitForPageLoad
		$I->comment("Exiting Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
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
	public function AdminCreateStoreGroupWithCustomWebsiteAndDefaultCategoryTest(AcceptanceTester $I)
	{
		$I->comment("Create custom store group with custom website and default category and verify AssertStoreGroupSuccessSaveMessage");
		$I->comment("Entering Action Group [createCustomStoreGroup] CreateCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageCreateCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: waitForSystemStorePageCreateCustomStoreGroup
		$I->click("#add_group"); // stepKey: selectCreateStoreCreateCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: selectCreateStoreCreateCustomStoreGroupWaitForPageLoad
		$I->selectOption("#group_website_id", "Second Website" . msq("customWebsite")); // stepKey: selectMainWebsiteCreateCustomStoreGroup
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: fillStoreNameCreateCustomStoreGroup
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: fillStoreCodeCreateCustomStoreGroup
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: selectStoreStatusCreateCustomStoreGroup
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateCustomStoreGroup
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateCustomStoreGroupWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateCustomStoreGroup
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateCustomStoreGroup
		$I->comment("Exiting Action Group [createCustomStoreGroup] CreateCustomStoreActionGroup");
		$I->comment("Search created store group(from above step) in grid and verify AssertStoreGroupInGrid message");
		$I->comment("Entering Action Group [seeCreatedStoreGroupInGrid] AssertStoreGroupInGridActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageSeeCreatedStoreGroupInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStorePageLoadSeeCreatedStoreGroupInGrid
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterSeeCreatedStoreGroupInGrid
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterSeeCreatedStoreGroupInGridWaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "store" . msq("customStoreGroup")); // stepKey: fillSearchStoreGroupFieldSeeCreatedStoreGroupInGrid
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonSeeCreatedStoreGroupInGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonSeeCreatedStoreGroupInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadSeeCreatedStoreGroupInGrid
		$I->see("store" . msq("customStoreGroup"), "(//*[@id='storeGrid_table']/tbody/tr)[1]"); // stepKey: seeAssertStoreGroupInGridMessageSeeCreatedStoreGroupInGrid
		$I->comment("Exiting Action Group [seeCreatedStoreGroupInGrid] AssertStoreGroupInGridActionGroup");
		$I->comment("Go to store group form page and verify AssertStoreGroupForm");
		$I->comment("Entering Action Group [seeCreatedStoreGroupForm] AssertStoreGroupFormActionGroup");
		$I->comment("Admin creates new Store group");
		$I->click(".col-group_title>a"); // stepKey: clickEditExistingStoreRowSeeCreatedStoreGroupForm
		$I->waitForPageLoad(30); // stepKey: waitTillAdminSystemStoreGroupPageSeeCreatedStoreGroupForm
		$I->seeInField("#group_website_id", "Second Website" . msq("customWebsite")); // stepKey: seeAssertWebsiteSeeCreatedStoreGroupForm
		$I->seeInField("#group_name", "store" . msq("customStoreGroup")); // stepKey: seeAssertStoreGroupNameSeeCreatedStoreGroupForm
		$I->seeInField("#group_code", "store" . msq("customStoreGroup")); // stepKey: seeAssertStoreGroupCodeSeeCreatedStoreGroupForm
		$I->seeInField("#group_root_category_id", "Default Category"); // stepKey: seeAssertRootCategorySeeCreatedStoreGroupForm
		$I->comment("Exiting Action Group [seeCreatedStoreGroupForm] AssertStoreGroupFormActionGroup");
		$I->comment("Also verify absence of delete button on store group form page(AssertStoreGroupNoDeleteButton)");
		$I->dontSee("#delete"); // stepKey: AssertStoreGroupNoDeleteButton
		$I->waitForPageLoad(30); // stepKey: AssertStoreGroupNoDeleteButtonWaitForPageLoad
	}
}
