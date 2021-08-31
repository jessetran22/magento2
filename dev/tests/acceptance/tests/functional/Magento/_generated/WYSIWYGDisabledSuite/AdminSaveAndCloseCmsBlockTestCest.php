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
 * @Title("[NO TESTCASEID]: Admin should be able to create a CMS block")
 * @Description("Admin should be able to create a CMS block using save and close<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminSaveAndCloseCmsBlockTest.xml<br>")
 * @group Cms
 * @group WYSIWYGDisabled
 */
class AdminSaveAndCloseCmsBlockTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteCreatedBlock] deleteBlock");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/"); // stepKey: navigateToCMSBlocksGridDeleteCreatedBlock
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1DeleteCreatedBlock
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterDeleteCreatedBlock
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2DeleteCreatedBlock
		$I->click("//button[text()='Filters']"); // stepKey: clickFilterBtnDeleteCreatedBlock
		$I->fillField("//div[@class='admin__form-field-control']/input[@name='identifier']", "block" . msq("_defaultBlock")); // stepKey: fillBlockIdentifierInputDeleteCreatedBlock
		$I->click("//span[text()='Apply Filters']"); // stepKey: applyFilterDeleteCreatedBlock
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForGridToLoadResultsDeleteCreatedBlock
		$I->waitForElementVisible("//div[text()='block" . msq("_defaultBlock") . "']//parent::td//following-sibling::td//button[text()='Select']", 30); // stepKey: waitForCMSPageGridDeleteCreatedBlock
		$I->click("//div[text()='block" . msq("_defaultBlock") . "']//parent::td//following-sibling::td//button[text()='Select']"); // stepKey: clickSelectDeleteCreatedBlock
		$I->waitForElementVisible("//div[text()='block" . msq("_defaultBlock") . "']//parent::td//following-sibling::td//a[text()='Edit']", 30); // stepKey: waitForEditLinkDeleteCreatedBlock
		$I->click("//div[text()='block" . msq("_defaultBlock") . "']//parent::td//following-sibling::td//a[text()='Edit']"); // stepKey: clickEditDeleteCreatedBlock
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForPageToLoadDeleteCreatedBlock
		$I->click("#delete"); // stepKey: deleteBlockDeleteCreatedBlock
		$I->waitForPageLoad(30); // stepKey: deleteBlockDeleteCreatedBlockWaitForPageLoad
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForOkButtonToBeVisibleDeleteCreatedBlock
		$I->waitForPageLoad(60); // stepKey: waitForOkButtonToBeVisibleDeleteCreatedBlockWaitForPageLoad
		$I->click(".action-primary.action-accept"); // stepKey: clickOkButtonDeleteCreatedBlock
		$I->waitForPageLoad(60); // stepKey: clickOkButtonDeleteCreatedBlockWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3DeleteCreatedBlock
		$I->see("You deleted the block."); // stepKey: seeSuccessMessageDeleteCreatedBlock
		$I->comment("Exiting Action Group [deleteCreatedBlock] deleteBlock");
		$I->comment("Entering Action Group [resetGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersResetGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersResetGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [resetGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"CMS Block Creation and Reset Removal"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminSaveAndCloseCmsBlockTest(AcceptanceTester $I)
	{
		$I->comment("Navigate to create cms block page and verify save split button");
		$I->comment("Entering Action Group [assertCmsBlockSaveSplitButton] VerifyCmsBlockSaveSplitButtonActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/new"); // stepKey: amOnBlocksCreationFormAssertCmsBlockSaveSplitButton
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AssertCmsBlockSaveSplitButton
		$I->comment("Verify Save&Duplicate button and Save&Close button");
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitBtn1AssertCmsBlockSaveSplitButton
		$I->waitForPageLoad(10); // stepKey: expandSplitBtn1AssertCmsBlockSaveSplitButtonWaitForPageLoad
		$I->waitForElementVisible("#save_and_duplicate", 30); // stepKey: waitForButtonMenuOpenedAssertCmsBlockSaveSplitButton
		$I->waitForPageLoad(10); // stepKey: waitForButtonMenuOpenedAssertCmsBlockSaveSplitButtonWaitForPageLoad
		$I->see("Save & Duplicate", "#save_and_duplicate"); // stepKey: seeSaveAndDuplicateAssertCmsBlockSaveSplitButton
		$I->waitForPageLoad(10); // stepKey: seeSaveAndDuplicateAssertCmsBlockSaveSplitButtonWaitForPageLoad
		$I->see("Save & Close", "#save_and_close"); // stepKey: seeSaveAndCloseAssertCmsBlockSaveSplitButton
		$I->waitForPageLoad(10); // stepKey: seeSaveAndCloseAssertCmsBlockSaveSplitButtonWaitForPageLoad
		$I->comment("Exiting Action Group [assertCmsBlockSaveSplitButton] VerifyCmsBlockSaveSplitButtonActionGroup");
		$I->comment("Create new CMS Block page");
		$I->comment("Entering Action Group [fillOutBlockContent] FillOutBlockContent");
		$I->fillField("input[name=title]", "Default Block" . msq("_defaultBlock")); // stepKey: fillFieldTitle1FillOutBlockContent
		$I->fillField("input[name=identifier]", "block" . msq("_defaultBlock")); // stepKey: fillFieldIdentifierFillOutBlockContent
		$I->selectOption("select[name=store_id]", "All Store View"); // stepKey: selectAllStoreViewFillOutBlockContent
		$I->fillField("textarea", "Here is a block test. Yeah!"); // stepKey: fillContentFieldFillOutBlockContent
		$I->comment("Exiting Action Group [fillOutBlockContent] FillOutBlockContent");
		$I->comment("Entering Action Group [saveCmsBlockContent] SaveAndCloseCMSBlockWithSplitButtonActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForExpandSplitButtonToBeVisibleSaveCmsBlockContent
		$I->waitForPageLoad(10); // stepKey: waitForExpandSplitButtonToBeVisibleSaveCmsBlockContentWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButtonSaveCmsBlockContent
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonSaveCmsBlockContentWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveBlockSaveCmsBlockContent
		$I->waitForPageLoad(10); // stepKey: clickSaveBlockSaveCmsBlockContentWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterClickingSaveSaveCmsBlockContent
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageAppearSaveCmsBlockContent
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveCmsBlockContent
		$I->see("You saved the block.", "#messages div.message-success"); // stepKey: assertSaveBlockSuccessMessageSaveCmsBlockContent
		$I->comment("Exiting Action Group [saveCmsBlockContent] SaveAndCloseCMSBlockWithSplitButtonActionGroup");
	}
}
