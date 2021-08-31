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
 * @Title("MC-25828: Check static blocks: ID should be unique per Store View")
 * @Description("Check static blocks: ID should be unique per Store View<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/CheckStaticBlocksTest.xml<br>")
 * @TestCaseId("MC-25828")
 * @group Cms
 * @group WYSIWYGDisabled
 */
class CheckStaticBlocksTestCest
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
		$I->comment("Entering Action Group [createAdditionalWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateAdditionalWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateAdditionalWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "Second Website" . msq("customWebsite")); // stepKey: enterWebsiteNameCreateAdditionalWebsite
		$I->fillField("#website_code", "second_website" . msq("customWebsite")); // stepKey: enterWebsiteCodeCreateAdditionalWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteCreateAdditionalWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteCreateAdditionalWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadCreateAdditionalWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageCreateAdditionalWebsite
		$I->comment("Exiting Action Group [createAdditionalWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Entering Action Group [createNewStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateNewStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateNewStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Second Website" . msq("customWebsite")); // stepKey: selectWebsiteCreateNewStore
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupNameCreateNewStore
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupCodeCreateNewStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateNewStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateNewStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateNewStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateNewStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateNewStore
		$I->comment("Exiting Action Group [createNewStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Entering Action Group [createNewStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateNewStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateNewStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStoreGroup")); // stepKey: selectStoreCreateNewStoreView
		$I->fillField("#store_name", "store" . msq("customStore")); // stepKey: enterStoreViewNameCreateNewStoreView
		$I->fillField("#store_code", "store" . msq("customStore")); // stepKey: enterStoreViewCodeCreateNewStoreView
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
		$I->comment("Entering Action Group [deleteCMSBlock] DeleteCMSBlockActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/"); // stepKey: navigateToCMSPagesGridDeleteCMSBlock
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteCMSBlock
		$I->click("//div[text()='Default Block" . msq("_defaultBlock") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: ClickOnSelectDeleteCMSBlock
		$I->click("//div[text()='Default Block" . msq("_defaultBlock") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Delete']"); // stepKey: ClickOnEditDeleteCMSBlock
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3DeleteCMSBlock
		$I->click(".action-primary.action-accept"); // stepKey: ClickToConfirmDeleteCMSBlock
		$I->waitForPageLoad(60); // stepKey: ClickToConfirmDeleteCMSBlockWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad4DeleteCMSBlock
		$I->see("You deleted the block."); // stepKey: VerifyBlockIsDeletedDeleteCMSBlock
		$I->comment("Exiting Action Group [deleteCMSBlock] DeleteCMSBlockActionGroup");
		$I->comment("Entering Action Group [deleteSecondCMSBlock] DeleteCMSBlockActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/"); // stepKey: navigateToCMSPagesGridDeleteSecondCMSBlock
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteSecondCMSBlock
		$I->click("//div[text()='Default Block" . msq("_defaultBlock") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: ClickOnSelectDeleteSecondCMSBlock
		$I->click("//div[text()='Default Block" . msq("_defaultBlock") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Delete']"); // stepKey: ClickOnEditDeleteSecondCMSBlock
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3DeleteSecondCMSBlock
		$I->click(".action-primary.action-accept"); // stepKey: ClickToConfirmDeleteSecondCMSBlock
		$I->waitForPageLoad(60); // stepKey: ClickToConfirmDeleteSecondCMSBlockWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad4DeleteSecondCMSBlock
		$I->see("You deleted the block."); // stepKey: VerifyBlockIsDeletedDeleteSecondCMSBlock
		$I->comment("Exiting Action Group [deleteSecondCMSBlock] DeleteCMSBlockActionGroup");
		$I->comment("Entering Action Group [clearFilters] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFilters
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilters] AdminClearFiltersActionGroup");
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
	 * @Stories({"MAGETWO-91559 - Static blocks with same ID appear in place of correct block"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function CheckStaticBlocksTest(AcceptanceTester $I)
	{
		$I->comment("Go to Cms blocks page");
		$I->comment("Entering Action Group [navigateToCMSBlocksGrid] AdminOpenCmsBlocksGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/"); // stepKey: navigateToCMSBlocksGridNavigateToCMSBlocksGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCMSBlocksGrid
		$I->comment("Exiting Action Group [navigateToCMSBlocksGrid] AdminOpenCmsBlocksGridActionGroup");
		$I->comment("Entering Action Group [verifyPageIsOpened] AssertAdminProperUrlIsShownActionGroup");
		$I->seeInCurrentUrl("cms/block/"); // stepKey: seePropertUrlVerifyPageIsOpened
		$I->comment("Exiting Action Group [verifyPageIsOpened] AssertAdminProperUrlIsShownActionGroup");
		$I->comment("Click to create new block");
		$I->comment("Entering Action Group [clickOnAddNewBlockButton] AdminPressAddNewCmsBlockButtonActionGroup");
		$I->click("#add"); // stepKey: clickOnAddNewBlockButtonClickOnAddNewBlockButton
		$I->waitForPageLoad(30); // stepKey: clickOnAddNewBlockButtonClickOnAddNewBlockButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickOnAddNewBlockButton
		$I->comment("Exiting Action Group [clickOnAddNewBlockButton] AdminPressAddNewCmsBlockButtonActionGroup");
		$I->comment("Entering Action Group [verifyNewCmsBlockPageIsOpened] AssertAdminProperUrlIsShownActionGroup");
		$I->seeInCurrentUrl("cms/block/new"); // stepKey: seePropertUrlVerifyNewCmsBlockPageIsOpened
		$I->comment("Exiting Action Group [verifyNewCmsBlockPageIsOpened] AssertAdminProperUrlIsShownActionGroup");
		$I->comment("Entering Action Group [FillOutBlockContent] FillOutBlockContent");
		$I->fillField("input[name=title]", "Default Block" . msq("_defaultBlock")); // stepKey: fillFieldTitle1FillOutBlockContent
		$I->fillField("input[name=identifier]", "block" . msq("_defaultBlock")); // stepKey: fillFieldIdentifierFillOutBlockContent
		$I->selectOption("select[name=store_id]", "All Store View"); // stepKey: selectAllStoreViewFillOutBlockContent
		$I->fillField("textarea", "Here is a block test. Yeah!"); // stepKey: fillContentFieldFillOutBlockContent
		$I->comment("Exiting Action Group [FillOutBlockContent] FillOutBlockContent");
		$I->comment("Entering Action Group [saveCmsBlock] AdminPressSaveCmsBlockButtonActionGroup");
		$I->click("#save-button"); // stepKey: clickOnSaveBlockSaveCmsBlock
		$I->waitForPageLoad(10); // stepKey: clickOnSaveBlockSaveCmsBlockWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSaveCmsBlock
		$I->comment("Exiting Action Group [saveCmsBlock] AdminPressSaveCmsBlockButtonActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleAssertSuccessMessage
		$I->see("You saved the block.", "#messages div.message-success"); // stepKey: verifyMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Add new BLock with the same data");
		$I->comment("Entering Action Group [openCmsBlocksGrid] AdminOpenCmsBlocksGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/"); // stepKey: navigateToCMSBlocksGridOpenCmsBlocksGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCmsBlocksGrid
		$I->comment("Exiting Action Group [openCmsBlocksGrid] AdminOpenCmsBlocksGridActionGroup");
		$I->comment("Entering Action Group [pressAddNewBlockButton] AdminPressAddNewCmsBlockButtonActionGroup");
		$I->click("#add"); // stepKey: clickOnAddNewBlockButtonPressAddNewBlockButton
		$I->waitForPageLoad(30); // stepKey: clickOnAddNewBlockButtonPressAddNewBlockButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadPressAddNewBlockButton
		$I->comment("Exiting Action Group [pressAddNewBlockButton] AdminPressAddNewCmsBlockButtonActionGroup");
		$I->comment("Entering Action Group [assertNewCmsBlockPageIsOpened] AssertAdminProperUrlIsShownActionGroup");
		$I->seeInCurrentUrl("cms/block/new"); // stepKey: seePropertUrlAssertNewCmsBlockPageIsOpened
		$I->comment("Exiting Action Group [assertNewCmsBlockPageIsOpened] AssertAdminProperUrlIsShownActionGroup");
		$I->comment("Entering Action Group [FillOutBlockContent1] FillOutBlockContent");
		$I->fillField("input[name=title]", "Default Block" . msq("_defaultBlock")); // stepKey: fillFieldTitle1FillOutBlockContent1
		$I->fillField("input[name=identifier]", "block" . msq("_defaultBlock")); // stepKey: fillFieldIdentifierFillOutBlockContent1
		$I->selectOption("select[name=store_id]", "All Store View"); // stepKey: selectAllStoreViewFillOutBlockContent1
		$I->fillField("textarea", "Here is a block test. Yeah!"); // stepKey: fillContentFieldFillOutBlockContent1
		$I->comment("Exiting Action Group [FillOutBlockContent1] FillOutBlockContent");
		$I->comment("Entering Action Group [clickOnSaveButton] AdminPressSaveCmsBlockButtonActionGroup");
		$I->click("#save-button"); // stepKey: clickOnSaveBlockClickOnSaveButton
		$I->waitForPageLoad(10); // stepKey: clickOnSaveBlockClickOnSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickOnSaveButton
		$I->comment("Exiting Action Group [clickOnSaveButton] AdminPressSaveCmsBlockButtonActionGroup");
		$I->comment("Entering Action Group [assertErrorMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForMessageVisibleAssertErrorMessage
		$I->see("A block identifier with the same properties already exists in the selected store.", "#messages div.message-error"); // stepKey: verifyMessageAssertErrorMessage
		$I->comment("Exiting Action Group [assertErrorMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Add new BLock with the same data for another store view");
		$I->comment("Entering Action Group [goToCmsBlocksGrid] AdminOpenCmsBlocksGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/"); // stepKey: navigateToCMSBlocksGridGoToCmsBlocksGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToCmsBlocksGrid
		$I->comment("Exiting Action Group [goToCmsBlocksGrid] AdminOpenCmsBlocksGridActionGroup");
		$I->comment("Entering Action Group [clickToAddNewButton] AdminPressAddNewCmsBlockButtonActionGroup");
		$I->click("#add"); // stepKey: clickOnAddNewBlockButtonClickToAddNewButton
		$I->waitForPageLoad(30); // stepKey: clickOnAddNewBlockButtonClickToAddNewButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickToAddNewButton
		$I->comment("Exiting Action Group [clickToAddNewButton] AdminPressAddNewCmsBlockButtonActionGroup");
		$I->comment("Entering Action Group [confirmNewCmsBlockPageIsOpened] AssertAdminProperUrlIsShownActionGroup");
		$I->seeInCurrentUrl("cms/block/new"); // stepKey: seePropertUrlConfirmNewCmsBlockPageIsOpened
		$I->comment("Exiting Action Group [confirmNewCmsBlockPageIsOpened] AssertAdminProperUrlIsShownActionGroup");
		$I->comment("Entering Action Group [FillOutBlockContent2] FillOutBlockContent");
		$I->fillField("input[name=title]", "Default Block" . msq("_defaultBlock")); // stepKey: fillFieldTitle1FillOutBlockContent2
		$I->fillField("input[name=identifier]", "block" . msq("_defaultBlock")); // stepKey: fillFieldIdentifierFillOutBlockContent2
		$I->selectOption("select[name=store_id]", "All Store View"); // stepKey: selectAllStoreViewFillOutBlockContent2
		$I->fillField("textarea", "Here is a block test. Yeah!"); // stepKey: fillContentFieldFillOutBlockContent2
		$I->comment("Exiting Action Group [FillOutBlockContent2] FillOutBlockContent");
		$I->comment("Entering Action Group [selectCustomStoreView] AdminSelectCMSBlockStoreViewActionGroup");
		$I->selectOption("select[name=store_id]", "store" . msq("customStore")); // stepKey: selectStoreViewSelectCustomStoreView
		$I->comment("Exiting Action Group [selectCustomStoreView] AdminSelectCMSBlockStoreViewActionGroup");
		$I->comment("Entering Action Group [saveNewCmsBlock] AdminPressSaveCmsBlockButtonActionGroup");
		$I->click("#save-button"); // stepKey: clickOnSaveBlockSaveNewCmsBlock
		$I->waitForPageLoad(10); // stepKey: clickOnSaveBlockSaveNewCmsBlockWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSaveNewCmsBlock
		$I->comment("Exiting Action Group [saveNewCmsBlock] AdminPressSaveCmsBlockButtonActionGroup");
		$I->comment("Entering Action Group [verifyBlockIsSaved] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleVerifyBlockIsSaved
		$I->see("You saved the block.", "#messages div.message-success"); // stepKey: verifyMessageVerifyBlockIsSaved
		$I->comment("Exiting Action Group [verifyBlockIsSaved] AssertMessageInAdminPanelActionGroup");
	}
}
