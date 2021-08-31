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
 * @Title("MAGETWO-96388: Check that Store View(language) switches correct")
 * @Description("Check that Store View(language) switches correct<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/StoreViewLanguageCorrectSwitchTest.xml<br>")
 * @TestCaseId("MAGETWO-96388")
 * @group Cms
 */
class StoreViewLanguageCorrectSwitchTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create Cms Pages");
		$I->createEntity("createFirstCmsPage", "hook", "_newDefaultCmsPage", [], []); // stepKey: createFirstCmsPage
		$I->createEntity("createSecondCmsPage", "hook", "_newDefaultCmsPage", [], []); // stepKey: createSecondCmsPage
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createFirstCmsPage", "hook"); // stepKey: deleteFirstCmsPage
		$I->deleteEntity("createSecondCmsPage", "hook"); // stepKey: deleteSecondCmsPage
		$I->comment("Entering Action Group [deleteStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "StoreView" . msq("NewStoreViewData")); // stepKey: fillStoreViewFilterFieldDeleteStoreView
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
	 * @Features({"Cms"})
	 * @Stories({"Store view language"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StoreViewLanguageCorrectSwitchTest(AcceptanceTester $I)
	{
		$I->comment("Create StoreView");
		$I->comment("Entering Action Group [createStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreView
		$I->fillField("#store_name", "StoreView" . msq("NewStoreViewData")); // stepKey: enterStoreViewNameCreateStoreView
		$I->fillField("#store_code", "StoreViewCode" . msq("NewStoreViewData")); // stepKey: enterStoreViewCodeCreateStoreView
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
		$I->comment("Add StoreView To Cms Page");
		$I->comment("Entering Action Group [gotToCmsPage] AddStoreViewToCmsPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridGotToCmsPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1GotToCmsPage
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterGotToCmsPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2GotToCmsPage
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingGotToCmsPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishGotToCmsPage
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingGotToCmsPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishGotToCmsPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createSecondCmsPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectCreatedCMSPageGotToCmsPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createSecondCmsPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']"); // stepKey: navigateToCreatedCMSPageGotToCmsPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3GotToCmsPage
		$I->click("div[data-index=websites]"); // stepKey: clickPageInWebsitesGotToCmsPage
		$I->waitForPageLoad(30); // stepKey: clickPageInWebsitesGotToCmsPageWaitForPageLoad
		$I->waitForElementVisible("//option[contains(text(),'StoreView" . msq("NewStoreViewData") . "')]", 30); // stepKey: waitForStoreGridReloadGotToCmsPage
		$I->clickWithLeftButton("//option[contains(text(),'StoreView" . msq("NewStoreViewData") . "')]"); // stepKey: clickStoreViewGotToCmsPage
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandButtonMenuGotToCmsPage
		$I->waitForPageLoad(10); // stepKey: expandButtonMenuGotToCmsPageWaitForPageLoad
		$I->waitForElementVisible("//ul[@data-ui-id='save-button-dropdown-menu']", 30); // stepKey: waitForSplitButtonMenuVisibleGotToCmsPage
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonMenuVisibleGotToCmsPageWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSavePageGotToCmsPage
		$I->waitForPageLoad(10); // stepKey: clickSavePageGotToCmsPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGotToCmsPage
		$I->see("You saved the page."); // stepKey: seeMessageGotToCmsPage
		$I->comment("Exiting Action Group [gotToCmsPage] AddStoreViewToCmsPageActionGroup");
		$I->comment("Check that Cms Page is open");
		$I->amOnPage("//" . $I->retrieveEntityField('createFirstCmsPage', 'identifier', 'test')); // stepKey: gotToFirstCmsPage
		$I->see($I->retrieveEntityField('createFirstCmsPage', 'title', 'test')); // stepKey: seePageTitle
		$I->comment("Switch StoreView and check that Cms Page is open");
		$I->comment("Entering Action Group [switchToCustomStoreView] StorefrontSwitchStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherSwitchToCustomStoreView
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownSwitchToCustomStoreView
		$I->click("li.view-StoreViewCode" . msq("NewStoreViewData") . ">a"); // stepKey: clickSelectStoreViewSwitchToCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchToCustomStoreView
		$I->comment("Exiting Action Group [switchToCustomStoreView] StorefrontSwitchStoreViewActionGroup");
		$I->amOnPage("//" . $I->retrieveEntityField('createSecondCmsPage', 'identifier', 'test')); // stepKey: gotToSecondCmsPage
		$I->see($I->retrieveEntityField('createSecondCmsPage', 'title', 'test')); // stepKey: seePageTitle1
		$I->comment("Open first Cms page on custom store view");
		$I->amOnPage("//" . $I->retrieveEntityField('createFirstCmsPage', 'identifier', 'test')); // stepKey: gotToFirstCmsPage1
		$I->see("Whoops, our bad..."); // stepKey: seePageError
		$I->comment("Switch to default store view and check Cms page");
		$I->comment("Entering Action Group [switchToDefualtStoreView] StorefrontSwitchDefaultStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherSwitchToDefualtStoreView
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownSwitchToDefualtStoreView
		$I->click("li.view-default>a"); // stepKey: clickSelectDefaultStoreViewSwitchToDefualtStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchToDefualtStoreView
		$I->comment("Exiting Action Group [switchToDefualtStoreView] StorefrontSwitchDefaultStoreViewActionGroup");
		$I->see($I->retrieveEntityField('createFirstCmsPage', 'title', 'test')); // stepKey: seePageTitle2
	}
}
