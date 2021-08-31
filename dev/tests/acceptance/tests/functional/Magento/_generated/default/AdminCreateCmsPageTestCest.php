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
 * @Title("MAGETWO-25580: Admin should be able to create a CMS Page")
 * @Description("Admin should be able to create a CMS Page<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminCreateCmsPageTest.xml<br>")
 * @TestCaseId("MAGETWO-25580")
 * @group Cms
 */
class AdminCreateCmsPageTestCest
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
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Stories({"Create a CMS Page via the Admin"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCmsPageTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToCmsPageGrid] AdminOpenCMSPagesGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridNavigateToCmsPageGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCmsPageGrid
		$I->comment("Exiting Action Group [navigateToCmsPageGrid] AdminOpenCMSPagesGridActionGroup");
		$I->comment("Entering Action Group [createNewPageWithBasicValues] CreateNewPageWithBasicValues");
		$I->click("#add"); // stepKey: clickAddNewPageCreateNewPageWithBasicValues
		$I->waitForPageLoad(30); // stepKey: clickAddNewPageCreateNewPageWithBasicValuesWaitForPageLoad
		$I->fillField("input[name=title]", "Test CMS Page"); // stepKey: fillFieldTitleCreateNewPageWithBasicValues
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentCreateNewPageWithBasicValues
		$I->fillField("input[name=content_heading]", "Test Content Heading"); // stepKey: fillFieldContentHeadingCreateNewPageWithBasicValues
		$I->fillField("#cms_page_form_content", "Sample page content. Yada yada yada."); // stepKey: fillFieldContentCreateNewPageWithBasicValues
		$I->click("div[data-index=search_engine_optimisation]"); // stepKey: clickExpandSearchEngineOptimisationCreateNewPageWithBasicValues
		$I->waitForPageLoad(30); // stepKey: clickExpandSearchEngineOptimisationCreateNewPageWithBasicValuesWaitForPageLoad
		$I->fillField("input[name=identifier]", "test-page-" . msq("_defaultCmsPage")); // stepKey: fillFieldUrlKeyCreateNewPageWithBasicValues
		$I->comment("Exiting Action Group [createNewPageWithBasicValues] CreateNewPageWithBasicValues");
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
		$I->comment("Entering Action Group [verifyCmsPage] VerifyCreatedCmsPage");
		$I->amOnPage("test-page-" . msq("_defaultCmsPage")); // stepKey: amOnPageTestPageVerifyCmsPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2VerifyCmsPage
		$I->see("Test Content Heading"); // stepKey: seeContentHeadingVerifyCmsPage
		$I->see("Sample page content. Yada yada yada."); // stepKey: seeContentVerifyCmsPage
		$I->comment("Exiting Action Group [verifyCmsPage] VerifyCreatedCmsPage");
		$I->comment("Entering Action Group [deletePage] DeletePageByUrlKeyActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: amOnCMSNewPageDeletePage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1DeletePage
		$I->click("//div[text()='test-page-" . msq("_defaultCmsPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectDeletePage
		$I->click("//div[text()='test-page-" . msq("_defaultCmsPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Delete']"); // stepKey: clickDeleteDeletePage
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForOkButtonToBeVisibleDeletePage
		$I->waitForPageLoad(60); // stepKey: waitForOkButtonToBeVisibleDeletePageWaitForPageLoad
		$I->click(".action-primary.action-accept"); // stepKey: clickOkButtonDeletePage
		$I->waitForPageLoad(60); // stepKey: clickOkButtonDeletePageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3DeletePage
		$I->see("The page has been deleted."); // stepKey: seeSuccessMessageDeletePage
		$I->comment("Exiting Action Group [deletePage] DeletePageByUrlKeyActionGroup");
	}
}
