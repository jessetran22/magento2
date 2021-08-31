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
 * @Title("MC-14677: Create disabled CMS Page via the Admin")
 * @Description("Admin should be able to create a CMS Page<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminCMSPageCreateDisabledPageTest.xml<br>")
 * @TestCaseId("MC-14677")
 * @group backend
 * @group Cms
 * @group mtf_migrated
 * @group WYSIWYGDisabled
 */
class AdminCMSPageCreateDisabledPageTestCest
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
	public function AdminCMSPageCreateDisabledPageTest(AcceptanceTester $I)
	{
		$I->comment("Go to New CMS Page page");
		$I->comment("Entering Action Group [navigateToCreateNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/new"); // stepKey: navigateToCreateNewPageNavigateToCreateNewPage
		$I->waitForPageLoad(30); // stepKey: waitForNewPagePageLoadNavigateToCreateNewPage
		$I->comment("Exiting Action Group [navigateToCreateNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->comment("Set page disabled");
		$I->comment("Entering Action Group [setCMSPageDisabled] AdminDisableCMSPageActionGroup");
		$I->seeElement("//input[@name='is_active' and @value='1']"); // stepKey: seePageIsEnabledSetCMSPageDisabled
		$I->click("div[data-index=is_active] .admin__actions-switch-label"); // stepKey: setPageDisabledSetCMSPageDisabled
		$I->comment("Exiting Action Group [setCMSPageDisabled] AdminDisableCMSPageActionGroup");
		$I->comment("Fill the CMS page form");
		$I->comment("Entering Action Group [fillBasicPageDataForDisabledPage] FillOutCMSPageContent");
		$I->fillField("input[name=title]", "testpage"); // stepKey: fillFieldTitleFillBasicPageDataForDisabledPage
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageFillBasicPageDataForDisabledPage
		$I->fillField("input[name=content_heading]", "Test Content Heading"); // stepKey: fillFieldContentHeadingFillBasicPageDataForDisabledPage
		$I->scrollTo("#cms_page_form_content"); // stepKey: scrollToPageContentFillBasicPageDataForDisabledPage
		$I->fillField("#cms_page_form_content", "Sample page content. Yada yada yada."); // stepKey: fillFieldContentFillBasicPageDataForDisabledPage
		$I->click("div[data-index=search_engine_optimisation]"); // stepKey: clickExpandSearchEngineOptimisationFillBasicPageDataForDisabledPage
		$I->waitForPageLoad(30); // stepKey: clickExpandSearchEngineOptimisationFillBasicPageDataForDisabledPageWaitForPageLoad
		$I->fillField("input[name=identifier]", "testpage-" . msq("_duplicatedCMSPage")); // stepKey: fillFieldUrlKeyFillBasicPageDataForDisabledPage
		$I->comment("Exiting Action Group [fillBasicPageDataForDisabledPage] FillOutCMSPageContent");
		$I->comment("Verify successfully saved");
		$I->comment("Entering Action Group [saveDisabledPage] SaveCmsPageActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForSplitButtonSaveDisabledPage
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonSaveDisabledPageWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButtonSaveDisabledPage
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonSaveDisabledPageWaitForPageLoad
		$I->waitForElementVisible("#save_and_close", 30); // stepKey: waitForSaveCmsPageSaveDisabledPage
		$I->waitForPageLoad(10); // stepKey: waitForSaveCmsPageSaveDisabledPageWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveCmsPageSaveDisabledPage
		$I->waitForPageLoad(10); // stepKey: clickSaveCmsPageSaveDisabledPageWaitForPageLoad
		$I->waitForElementVisible("#add", 1); // stepKey: waitForCmsPageSaveButtonSaveDisabledPage
		$I->waitForPageLoad(30); // stepKey: waitForCmsPageSaveButtonSaveDisabledPageWaitForPageLoad
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveDisabledPage
		$I->see("You saved the page.", ".message-success"); // stepKey: assertSavePageSuccessMessageSaveDisabledPage
		$I->comment("Exiting Action Group [saveDisabledPage] SaveCmsPageActionGroup");
		$I->comment("Check that page is disabled on frontend");
		$I->comment("Entering Action Group [goToCMSPageOnStorefront] StorefrontGoToCMSPageActionGroup");
		$I->amOnPage("//testpage-" . msq("_duplicatedCMSPage")); // stepKey: amOnCmsPageOnStorefrontGoToCMSPageOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOnStorefrontGoToCMSPageOnStorefront
		$I->comment("Exiting Action Group [goToCMSPageOnStorefront] StorefrontGoToCMSPageActionGroup");
		$I->comment("Entering Action Group [seeNotFoundError] AssertCMSPageNotFoundOnStorefrontActionGroup");
		$I->see("Whoops, our bad..."); // stepKey: seePageErrorNotFoundSeeNotFoundError
		$I->comment("Exiting Action Group [seeNotFoundError] AssertCMSPageNotFoundOnStorefrontActionGroup");
		$I->comment("Delete page");
		$I->comment("Entering Action Group [deleteDisabledPage] DeletePageByUrlKeyActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: amOnCMSNewPageDeleteDisabledPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1DeleteDisabledPage
		$I->click("//div[text()='testpage-" . msq("_duplicatedCMSPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectDeleteDisabledPage
		$I->click("//div[text()='testpage-" . msq("_duplicatedCMSPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Delete']"); // stepKey: clickDeleteDeleteDisabledPage
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForOkButtonToBeVisibleDeleteDisabledPage
		$I->waitForPageLoad(60); // stepKey: waitForOkButtonToBeVisibleDeleteDisabledPageWaitForPageLoad
		$I->click(".action-primary.action-accept"); // stepKey: clickOkButtonDeleteDisabledPage
		$I->waitForPageLoad(60); // stepKey: clickOkButtonDeleteDisabledPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3DeleteDisabledPage
		$I->see("The page has been deleted."); // stepKey: seeSuccessMessageDeleteDisabledPage
		$I->comment("Exiting Action Group [deleteDisabledPage] DeletePageByUrlKeyActionGroup");
	}
}
