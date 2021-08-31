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
 * @Title("MC-14678: Create CMS Page that contains block content via the Admin")
 * @Description("Admin should be able to create a CMS Page<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminCMSPageCreatePageWithBlockTest.xml<br>")
 * @TestCaseId("MC-14678")
 * @group backend
 * @group Cms
 * @group mtf_migrated
 * @group WYSIWYGDisabled
 */
class AdminCMSPageCreatePageWithBlockTestCest
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
	 * @Stories({"Create a CMS Page via the Admin"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCMSPageCreatePageWithBlockTest(AcceptanceTester $I)
	{
		$I->comment("Go to New CMS Page page");
		$I->comment("Entering Action Group [navigateToCreateNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/new"); // stepKey: navigateToCreateNewPageNavigateToCreateNewPage
		$I->waitForPageLoad(30); // stepKey: waitForNewPagePageLoadNavigateToCreateNewPage
		$I->comment("Exiting Action Group [navigateToCreateNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->comment("Entering Action Group [fillBasicPageData] FillOutCMSPageContent");
		$I->fillField("input[name=title]", "testpage"); // stepKey: fillFieldTitleFillBasicPageData
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageFillBasicPageData
		$I->fillField("input[name=content_heading]", "Test Content Heading"); // stepKey: fillFieldContentHeadingFillBasicPageData
		$I->scrollTo("#cms_page_form_content"); // stepKey: scrollToPageContentFillBasicPageData
		$I->fillField("#cms_page_form_content", "Sample page content. Yada yada yada."); // stepKey: fillFieldContentFillBasicPageData
		$I->click("div[data-index=search_engine_optimisation]"); // stepKey: clickExpandSearchEngineOptimisationFillBasicPageData
		$I->waitForPageLoad(30); // stepKey: clickExpandSearchEngineOptimisationFillBasicPageDataWaitForPageLoad
		$I->fillField("input[name=identifier]", "testpage-" . msq("_duplicatedCMSPage")); // stepKey: fillFieldUrlKeyFillBasicPageData
		$I->comment("Exiting Action Group [fillBasicPageData] FillOutCMSPageContent");
		$I->comment("Entering Action Group [fillContentField] AdminFillCMSPageContentFieldActionGroup");
		$I->fillField("#cms_page_form_content", "{{block class='Magento\Framework\View\Element\Text' text='bla bla bla' cache_key='BACKEND_ACL_RESOURCES' cache_lifetime=999}}"); // stepKey: fillFieldContentFillContentField
		$I->comment("Exiting Action Group [fillContentField] AdminFillCMSPageContentFieldActionGroup");
		$I->comment("Entering Action Group [selectCMSPageStoreViewForPageWithBlock] AdminSelectCMSPageStoreViewActionGroup");
		$I->click("div[data-index=websites]"); // stepKey: clickPageInWebsitesSelectCMSPageStoreViewForPageWithBlock
		$I->waitForPageLoad(30); // stepKey: clickPageInWebsitesSelectCMSPageStoreViewForPageWithBlockWaitForPageLoad
		$I->waitForElementVisible("//option[contains(text(),'Default Store View')]", 30); // stepKey: waitForStoreGridReloadSelectCMSPageStoreViewForPageWithBlock
		$I->clickWithLeftButton("//option[contains(text(),'Default Store View')]"); // stepKey: clickStoreViewSelectCMSPageStoreViewForPageWithBlock
		$I->comment("Exiting Action Group [selectCMSPageStoreViewForPageWithBlock] AdminSelectCMSPageStoreViewActionGroup");
		$I->comment("Verify successfully saved");
		$I->comment("Entering Action Group [savePageWithBlock] SaveCmsPageActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForSplitButtonSavePageWithBlock
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonSavePageWithBlockWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButtonSavePageWithBlock
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonSavePageWithBlockWaitForPageLoad
		$I->waitForElementVisible("#save_and_close", 30); // stepKey: waitForSaveCmsPageSavePageWithBlock
		$I->waitForPageLoad(10); // stepKey: waitForSaveCmsPageSavePageWithBlockWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveCmsPageSavePageWithBlock
		$I->waitForPageLoad(10); // stepKey: clickSaveCmsPageSavePageWithBlockWaitForPageLoad
		$I->waitForElementVisible("#add", 1); // stepKey: waitForCmsPageSaveButtonSavePageWithBlock
		$I->waitForPageLoad(30); // stepKey: waitForCmsPageSaveButtonSavePageWithBlockWaitForPageLoad
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSavePageWithBlock
		$I->see("You saved the page.", ".message-success"); // stepKey: assertSavePageSuccessMessageSavePageWithBlock
		$I->comment("Exiting Action Group [savePageWithBlock] SaveCmsPageActionGroup");
		$I->comment("verify page on frontend");
		$I->comment("Entering Action Group [navigateToPageOnStoreFront] StorefrontGoToCMSPageActionGroup");
		$I->amOnPage("//testpage-" . msq("_duplicatedCMSPage")); // stepKey: amOnCmsPageOnStorefrontNavigateToPageOnStoreFront
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOnStorefrontNavigateToPageOnStoreFront
		$I->comment("Exiting Action Group [navigateToPageOnStoreFront] StorefrontGoToCMSPageActionGroup");
		$I->comment("Entering Action Group [verifyPageWithBlockDataOnFrontend] AssertStoreFrontCMSPageActionGroup");
		$I->see("testpage", "//div[@class='breadcrumbs']//ul/li[@class='item cms_page']"); // stepKey: seeTitleVerifyPageWithBlockDataOnFrontend
		$I->see("Test Content Heading", "#maincontent .page-title"); // stepKey: seeContentHeadingVerifyPageWithBlockDataOnFrontend
		$I->see("bla bla bla", "#maincontent"); // stepKey: seeContentVerifyPageWithBlockDataOnFrontend
		$I->comment("Exiting Action Group [verifyPageWithBlockDataOnFrontend] AssertStoreFrontCMSPageActionGroup");
		$I->comment("Delete page with block");
		$I->comment("Entering Action Group [deletePageWithBlock] DeletePageByUrlKeyActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: amOnCMSNewPageDeletePageWithBlock
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1DeletePageWithBlock
		$I->click("//div[text()='testpage-" . msq("_duplicatedCMSPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectDeletePageWithBlock
		$I->click("//div[text()='testpage-" . msq("_duplicatedCMSPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Delete']"); // stepKey: clickDeleteDeletePageWithBlock
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForOkButtonToBeVisibleDeletePageWithBlock
		$I->waitForPageLoad(60); // stepKey: waitForOkButtonToBeVisibleDeletePageWithBlockWaitForPageLoad
		$I->click(".action-primary.action-accept"); // stepKey: clickOkButtonDeletePageWithBlock
		$I->waitForPageLoad(60); // stepKey: clickOkButtonDeletePageWithBlockWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3DeletePageWithBlock
		$I->see("The page has been deleted."); // stepKey: seeSuccessMessageDeletePageWithBlock
		$I->comment("Exiting Action Group [deletePageWithBlock] DeletePageByUrlKeyActionGroup");
	}
}
