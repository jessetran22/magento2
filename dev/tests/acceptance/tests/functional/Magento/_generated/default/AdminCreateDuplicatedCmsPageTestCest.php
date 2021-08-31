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
 * @Title("MAGETWO-89184: Admin should be able to duplicate a CMS Page")
 * @Description("Admin should be able to duplicate a CMS Page<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminCreateDuplicatedCmsPageTest.xml<br>")
 * @TestCaseId("MAGETWO-89184")
 * @group Cms
 */
class AdminCreateDuplicatedCmsPageTestCest
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
	 * @Stories({"CMS Page Duplication and Reset Removal MAGETWO-87096"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateDuplicatedCmsPageTest(AcceptanceTester $I)
	{
		$I->comment("Navigate to create a CMS page and Verify Save&Duplicate - Save&Close button");
		$I->comment("Entering Action Group [verifyCmsPageSaveButton] AssertAdminCmsPageSaveSplitButtonActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/new"); // stepKey: amOnPageCreationFormVerifyCmsPageSaveButton
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1VerifyCmsPageSaveButton
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitBtn1VerifyCmsPageSaveButton
		$I->waitForPageLoad(10); // stepKey: expandSplitBtn1VerifyCmsPageSaveButtonWaitForPageLoad
		$I->see("Save & Duplicate", "#save_and_duplicate"); // stepKey: seeSaveAndDuplicateVerifyCmsPageSaveButton
		$I->waitForPageLoad(10); // stepKey: seeSaveAndDuplicateVerifyCmsPageSaveButtonWaitForPageLoad
		$I->see("Save & Close", "#save_and_close"); // stepKey: seeSaveAndCloseVerifyCmsPageSaveButton
		$I->waitForPageLoad(10); // stepKey: seeSaveAndCloseVerifyCmsPageSaveButtonWaitForPageLoad
		$I->comment("Exiting Action Group [verifyCmsPageSaveButton] AssertAdminCmsPageSaveSplitButtonActionGroup");
		$I->comment("Filled out Content");
		$I->comment("Entering Action Group [FillOutPageContent] FillOutCMSPageContent");
		$I->fillField("input[name=title]", "testpage"); // stepKey: fillFieldTitleFillOutPageContent
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageFillOutPageContent
		$I->fillField("input[name=content_heading]", "Test Content Heading"); // stepKey: fillFieldContentHeadingFillOutPageContent
		$I->scrollTo("#cms_page_form_content"); // stepKey: scrollToPageContentFillOutPageContent
		$I->fillField("#cms_page_form_content", "Sample page content. Yada yada yada."); // stepKey: fillFieldContentFillOutPageContent
		$I->click("div[data-index=search_engine_optimisation]"); // stepKey: clickExpandSearchEngineOptimisationFillOutPageContent
		$I->waitForPageLoad(30); // stepKey: clickExpandSearchEngineOptimisationFillOutPageContentWaitForPageLoad
		$I->fillField("input[name=identifier]", "testpage-" . msq("_duplicatedCMSPage")); // stepKey: fillFieldUrlKeyFillOutPageContent
		$I->comment("Exiting Action Group [FillOutPageContent] FillOutCMSPageContent");
		$I->comment("Click save and duplicate action");
		$I->comment("Entering Action Group [clickSaveAndDuplicateButton] AdminSaveAndDuplicateCMSPageWithSplitButtonActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForExpandSplitButtonToBeVisibleClickSaveAndDuplicateButton
		$I->waitForPageLoad(10); // stepKey: waitForExpandSplitButtonToBeVisibleClickSaveAndDuplicateButtonWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitBtn2ClickSaveAndDuplicateButton
		$I->waitForPageLoad(10); // stepKey: expandSplitBtn2ClickSaveAndDuplicateButtonWaitForPageLoad
		$I->click("#save_and_duplicate"); // stepKey: clickSaveAndDuplicateClickSaveAndDuplicateButton
		$I->waitForPageLoad(10); // stepKey: clickSaveAndDuplicateClickSaveAndDuplicateButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterClickingSaveAndDuplicateClickSaveAndDuplicateButton
		$I->see("You saved the page."); // stepKey: seeSavedPageMsgOnFormClickSaveAndDuplicateButton
		$I->see("You duplicated the page."); // stepKey: seeDuplicatedPageMsgClickSaveAndDuplicateButton
		$I->comment("Exiting Action Group [clickSaveAndDuplicateButton] AdminSaveAndDuplicateCMSPageWithSplitButtonActionGroup");
		$I->comment("Verify duplicated CMS Page");
		$I->seeElement("//input[@name='is_active' and @value='0']"); // stepKey: seeBlockNotEnable
		$I->comment("Entering Action Group [assertContent] AssertCMSPageContentActionGroup");
		$grabTextFromTitleAssertContent = $I->grabValueFrom("input[name=title]"); // stepKey: grabTextFromTitleAssertContent
		$I->assertEquals("testpage", $grabTextFromTitleAssertContent, "pass"); // stepKey: assertTitleAssertContent
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageAssertContent
		$grabTextFromContentAssertContent = $I->grabValueFrom("#cms_page_form_content"); // stepKey: grabTextFromContentAssertContent
		$I->assertEquals("Sample page content. Yada yada yada.", $grabTextFromContentAssertContent, "pass"); // stepKey: assertContentAssertContent
		$I->click("div[data-index=search_engine_optimisation]"); // stepKey: clickExpandSearchEngineOptimisationAssertContent
		$I->waitForPageLoad(30); // stepKey: clickExpandSearchEngineOptimisationAssertContentWaitForPageLoad
		$setAttributeAssertContent = $I->executeJS("(el = document.querySelector('[name=\'identifier\']')) && el['se' + 'tAt' + 'tribute']('data-value', el.value.split('-')[0]);"); // stepKey: setAttributeAssertContent
		$I->seeElement("//input[contains(@data-value,'testpage')]"); // stepKey: seeAssertContent
		$I->comment("Exiting Action Group [assertContent] AssertCMSPageContentActionGroup");
		$I->comment("Click Save Button");
		$I->comment("Entering Action Group [clickSaveCmsPageButton] SaveCmsPageActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForSplitButtonClickSaveCmsPageButton
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonClickSaveCmsPageButtonWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButtonClickSaveCmsPageButton
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonClickSaveCmsPageButtonWaitForPageLoad
		$I->waitForElementVisible("#save_and_close", 30); // stepKey: waitForSaveCmsPageClickSaveCmsPageButton
		$I->waitForPageLoad(10); // stepKey: waitForSaveCmsPageClickSaveCmsPageButtonWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveCmsPageClickSaveCmsPageButton
		$I->waitForPageLoad(10); // stepKey: clickSaveCmsPageClickSaveCmsPageButtonWaitForPageLoad
		$I->waitForElementVisible("#add", 1); // stepKey: waitForCmsPageSaveButtonClickSaveCmsPageButton
		$I->waitForPageLoad(30); // stepKey: waitForCmsPageSaveButtonClickSaveCmsPageButtonWaitForPageLoad
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageClickSaveCmsPageButton
		$I->see("You saved the page.", ".message-success"); // stepKey: assertSavePageSuccessMessageClickSaveCmsPageButton
		$I->comment("Exiting Action Group [clickSaveCmsPageButton] SaveCmsPageActionGroup");
		$I->comment("Entering Action Group [deleteCMSPage] DeletePageByUrlKeyActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: amOnCMSNewPageDeleteCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1DeleteCMSPage
		$I->click("//div[text()='testpage-" . msq("_duplicatedCMSPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectDeleteCMSPage
		$I->click("//div[text()='testpage-" . msq("_duplicatedCMSPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Delete']"); // stepKey: clickDeleteDeleteCMSPage
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForOkButtonToBeVisibleDeleteCMSPage
		$I->waitForPageLoad(60); // stepKey: waitForOkButtonToBeVisibleDeleteCMSPageWaitForPageLoad
		$I->click(".action-primary.action-accept"); // stepKey: clickOkButtonDeleteCMSPage
		$I->waitForPageLoad(60); // stepKey: clickOkButtonDeleteCMSPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3DeleteCMSPage
		$I->see("The page has been deleted."); // stepKey: seeSuccessMessageDeleteCMSPage
		$I->comment("Exiting Action Group [deleteCMSPage] DeletePageByUrlKeyActionGroup");
	}
}
