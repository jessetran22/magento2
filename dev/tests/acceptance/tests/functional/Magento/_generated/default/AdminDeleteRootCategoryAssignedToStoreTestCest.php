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
 * @Title("MC-6050: Cannot delete root category assigned to some store")
 * @Description("Login as admin and root category can not be deleted when category is assigned with any store.<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminDeleteRootCategoryAssignedToStoreTest.xml<br>")
 * @TestCaseId("MC-6050")
 * @group Catalog
 * @group mtf_migrated
 */
class AdminDeleteRootCategoryAssignedToStoreTestCest
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
		$I->createEntity("rootCategory", "hook", "NewRootCategory", [], []); // stepKey: rootCategory
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteCreatedStore] DeleteCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteCreatedStore
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteCreatedStore
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteCreatedStoreWaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "store" . msq("customStore")); // stepKey: fillSearchStoreGroupFieldDeleteCreatedStore
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteCreatedStore
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteCreatedStoreWaitForPageLoad
		$I->see("store" . msq("customStore"), ".col-group_title>a"); // stepKey: verifyThatCorrectStoreGroupFoundDeleteCreatedStore
		$I->click(".col-group_title>a"); // stepKey: clickEditExistingStoreRowDeleteCreatedStore
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteCreatedStore
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteCreatedStore
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteCreatedStoreWaitForPageLoad
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteCreatedStore
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteCreatedStore
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteCreatedStoreWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteCreatedStore
		$I->see("You deleted the store.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCreatedStore
		$I->comment("Exiting Action Group [deleteCreatedStore] DeleteCustomStoreActionGroup");
		$I->deleteEntity("rootCategory", "hook"); // stepKey: deleteRootCategory
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
	 * @Stories({"Delete categories"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteRootCategoryAssignedToStoreTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [amOnAdminSystemStorePage] AdminSystemStoreOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToSystemStoreAmOnAdminSystemStorePage
		$I->waitForPageLoad(30); // stepKey: waitForPageAdminSystemStoreLoadAmOnAdminSystemStorePage
		$I->comment("Exiting Action Group [amOnAdminSystemStorePage] AdminSystemStoreOpenPageActionGroup");
		$I->click("#add_group"); // stepKey: selectCreateStore
		$I->waitForPageLoad(30); // stepKey: selectCreateStoreWaitForPageLoad
		$I->fillField("#group_name", "store" . msq("customStore")); // stepKey: fillStoreName
		$I->fillField("#group_code", "store" . msq("customStore")); // stepKey: fillStoreCode
		$I->selectOption("#group_root_category_id", "NewRootCategory" . msq("NewRootCategory")); // stepKey: selectStoreStatus
		$I->click("#save"); // stepKey: clickSaveStoreButton
		$I->waitForPageLoad(90); // stepKey: clickSaveStoreButtonWaitForPageLoad
		$I->see("You saved the store."); // stepKey: seeSaveMessage
		$I->comment("Verify Delete Root Category can not be deleted");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage1] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage1
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage1
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage1] AdminOpenCategoryPageActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage2
		$I->comment("Entering Action Group [expandToSeeAllCategories] AdminExpandCategoryTreeActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeExpandToSeeAllCategories
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadExpandToSeeAllCategories
		$I->comment("Exiting Action Group [expandToSeeAllCategories] AdminExpandCategoryTreeActionGroup");
		$I->click("//a/span[contains(text(), 'NewRootCategory" . msq("NewRootCategory") . "')]"); // stepKey: clickRootCategoryInTree
		$I->waitForPageLoad(30); // stepKey: clickRootCategoryInTreeWaitForPageLoad
		$I->comment("Verify Delete button is not displayed");
		$I->dontSeeElement(".page-actions-inner #delete"); // stepKey: dontSeeDeleteButton
		$I->waitForPageLoad(30); // stepKey: dontSeeDeleteButtonWaitForPageLoad
	}
}
