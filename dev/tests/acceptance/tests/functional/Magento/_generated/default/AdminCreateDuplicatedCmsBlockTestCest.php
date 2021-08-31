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
 * @Title("MAGETWO-89185: Admin should be able to duplicate a CMS block")
 * @Description("Admin should be able to duplicate a CMS block<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminCreateCmsBlockTest.xml<br>")
 * @TestCaseId("MAGETWO-89185")
 * @group Cms
 */
class AdminCreateDuplicatedCmsBlockTestCest
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
		$I->comment("Entering Action Group [loginGetFromGeneralFile] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginGetFromGeneralFile
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginGetFromGeneralFile
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginGetFromGeneralFile
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginGetFromGeneralFile
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginGetFromGeneralFileWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginGetFromGeneralFile
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginGetFromGeneralFile
		$I->comment("Exiting Action Group [loginGetFromGeneralFile] AdminLoginActionGroup");
		$I->comment("Entering Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
		$disableWYSIWYGDisableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled disabled", 60); // stepKey: disableWYSIWYGDisableWYSIWYG
		$I->comment($disableWYSIWYGDisableWYSIWYG);
		$I->comment("Exiting Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
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
	 * @Stories({"CMS Block Duplication and Reset Removal MAGETWO-88797"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateDuplicatedCmsBlockTest(AcceptanceTester $I)
	{
		$I->comment("Navigate to create cms block page and verify save split button");
		$I->comment("Entering Action Group [verifyCmsBlockSaveButton] VerifyCmsBlockSaveSplitButtonActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/new"); // stepKey: amOnBlocksCreationFormVerifyCmsBlockSaveButton
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1VerifyCmsBlockSaveButton
		$I->comment("Verify Save&Duplicate button and Save&Close button");
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitBtn1VerifyCmsBlockSaveButton
		$I->waitForPageLoad(10); // stepKey: expandSplitBtn1VerifyCmsBlockSaveButtonWaitForPageLoad
		$I->waitForElementVisible("#save_and_duplicate", 30); // stepKey: waitForButtonMenuOpenedVerifyCmsBlockSaveButton
		$I->waitForPageLoad(10); // stepKey: waitForButtonMenuOpenedVerifyCmsBlockSaveButtonWaitForPageLoad
		$I->see("Save & Duplicate", "#save_and_duplicate"); // stepKey: seeSaveAndDuplicateVerifyCmsBlockSaveButton
		$I->waitForPageLoad(10); // stepKey: seeSaveAndDuplicateVerifyCmsBlockSaveButtonWaitForPageLoad
		$I->see("Save & Close", "#save_and_close"); // stepKey: seeSaveAndCloseVerifyCmsBlockSaveButton
		$I->waitForPageLoad(10); // stepKey: seeSaveAndCloseVerifyCmsBlockSaveButtonWaitForPageLoad
		$I->comment("Exiting Action Group [verifyCmsBlockSaveButton] VerifyCmsBlockSaveSplitButtonActionGroup");
		$I->comment("Create new CMS Block page");
		$I->comment("Entering Action Group [FillOutBlockContent] FillOutBlockContent");
		$I->fillField("input[name=title]", "Default Block" . msq("_defaultBlock")); // stepKey: fillFieldTitle1FillOutBlockContent
		$I->fillField("input[name=identifier]", "block" . msq("_defaultBlock")); // stepKey: fillFieldIdentifierFillOutBlockContent
		$I->selectOption("select[name=store_id]", "All Store View"); // stepKey: selectAllStoreViewFillOutBlockContent
		$I->fillField("textarea", "Here is a block test. Yeah!"); // stepKey: fillContentFieldFillOutBlockContent
		$I->comment("Exiting Action Group [FillOutBlockContent] FillOutBlockContent");
		$I->comment("Click save and duplicate action");
		$I->comment("Entering Action Group [clickSaveAndDuplicateButton] SaveAndDuplicateCMSBlockWithSplitButtonActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForExpandSplitButtonToBeVisibleClickSaveAndDuplicateButton
		$I->waitForPageLoad(10); // stepKey: waitForExpandSplitButtonToBeVisibleClickSaveAndDuplicateButtonWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButtonClickSaveAndDuplicateButton
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonClickSaveAndDuplicateButtonWaitForPageLoad
		$I->click("#save_and_duplicate"); // stepKey: clickSaveAndDuplicateClickSaveAndDuplicateButton
		$I->waitForPageLoad(10); // stepKey: clickSaveAndDuplicateClickSaveAndDuplicateButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterClickingSaveClickSaveAndDuplicateButton
		$I->see("You saved the block."); // stepKey: assertSaveBlockSuccessMessageClickSaveAndDuplicateButton
		$I->see("You duplicated the block."); // stepKey: seeDuplicatedBlockMsgClickSaveAndDuplicateButton
		$I->comment("Exiting Action Group [clickSaveAndDuplicateButton] SaveAndDuplicateCMSBlockWithSplitButtonActionGroup");
		$I->comment("Verify duplicated CMS Block Page");
		$I->seeElement("//input[@name='is_active' and @value='0']"); // stepKey: seeBlockNotEnable
		$I->comment("Entering Action Group [assertContent] AssertBlockContent");
		$grabTextFromTitleAssertContent = $I->grabValueFrom("input[name=title]"); // stepKey: grabTextFromTitleAssertContent
		$I->assertEquals("Default Block" . msq("_defaultBlock"), $grabTextFromTitleAssertContent, "pass"); // stepKey: assertTitleAssertContent
		$setAttributeAssertContent = $I->executeJS("(el = document.querySelector('[name=\'identifier\']')) && el['se' + 'tAt' + 'tribute']('data-value', el.value.split('-')[0]);"); // stepKey: setAttributeAssertContent
		$I->seeElement("//input[contains(@data-value,'block" . msq("_defaultBlock") . "')]"); // stepKey: seeAssertContent
		$grabTextFromContentAssertContent = $I->grabValueFrom("textarea"); // stepKey: grabTextFromContentAssertContent
		$I->assertEquals("Here is a block test. Yeah!", $grabTextFromContentAssertContent, "pass"); // stepKey: assertContentAssertContent
		$I->comment("Exiting Action Group [assertContent] AssertBlockContent");
		$I->comment("Click save and close button");
		$I->comment("Entering Action Group [saveAndCloseAction] SaveAndCloseCMSBlockWithSplitButtonActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForExpandSplitButtonToBeVisibleSaveAndCloseAction
		$I->waitForPageLoad(10); // stepKey: waitForExpandSplitButtonToBeVisibleSaveAndCloseActionWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButtonSaveAndCloseAction
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonSaveAndCloseActionWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveBlockSaveAndCloseAction
		$I->waitForPageLoad(10); // stepKey: clickSaveBlockSaveAndCloseActionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterClickingSaveSaveAndCloseAction
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageAppearSaveAndCloseAction
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveAndCloseAction
		$I->see("You saved the block.", "#messages div.message-success"); // stepKey: assertSaveBlockSuccessMessageSaveAndCloseAction
		$I->comment("Exiting Action Group [saveAndCloseAction] SaveAndCloseCMSBlockWithSplitButtonActionGroup");
		$I->seeElement("div[data-role='grid-wrapper']"); // stepKey: seeGridPage
	}
}
