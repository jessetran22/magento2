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
 * @Title("MC-14674: Update CMS Page via the Admin")
 * @Description("Admin should be able to update a CMS Page<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminCmsPageUpdateTest.xml<br>")
 * @TestCaseId("MC-14674")
 * @group backend
 * @group cMSContent
 * @group mtf_migrated
 * @group WYSIWYGDisabled
 */
class AdminCmsPageUpdateTestCest
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
		$I->createEntity("existingCMSPage", "hook", "_defaultCmsPage", [], []); // stepKey: existingCMSPage
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("existingCMSPage", "hook"); // stepKey: deleteCMSPage
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
	 * @Stories({"Update CMS Page via the Admin"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCmsPageUpdateTest(AcceptanceTester $I)
	{
		$I->comment("Navigate to Page in Admin");
		$I->comment("Entering Action Group [navigateToCreatedCMSPage] NavigateToCreatedCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridNavigateToCreatedCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedCMSPage
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterNavigateToCreatedCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedCMSPage
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingNavigateToCreatedCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishNavigateToCreatedCMSPage
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingNavigateToCreatedCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishNavigateToCreatedCMSPage
		$I->click("//div[text()='" . $I->retrieveEntityField('existingCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectCreatedCMSPageNavigateToCreatedCMSPage
		$I->click("//div[text()='" . $I->retrieveEntityField('existingCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']"); // stepKey: navigateToCreatedCMSPageNavigateToCreatedCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCreatedCMSPage
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageNavigateToCreatedCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCreatedCMSPage
		$I->comment("Exiting Action Group [navigateToCreatedCMSPage] NavigateToCreatedCMSPageActionGroup");
		$I->comment("Fill data using _duplicatedCMSPage");
		$I->comment("Entering Action Group [fillNewData] FillOutCMSPageContent");
		$I->fillField("input[name=title]", "testpage"); // stepKey: fillFieldTitleFillNewData
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageFillNewData
		$I->fillField("input[name=content_heading]", "Test Content Heading"); // stepKey: fillFieldContentHeadingFillNewData
		$I->scrollTo("#cms_page_form_content"); // stepKey: scrollToPageContentFillNewData
		$I->fillField("#cms_page_form_content", "Sample page content. Yada yada yada."); // stepKey: fillFieldContentFillNewData
		$I->click("div[data-index=search_engine_optimisation]"); // stepKey: clickExpandSearchEngineOptimisationFillNewData
		$I->waitForPageLoad(30); // stepKey: clickExpandSearchEngineOptimisationFillNewDataWaitForPageLoad
		$I->fillField("input[name=identifier]", "testpage-" . msq("_duplicatedCMSPage")); // stepKey: fillFieldUrlKeyFillNewData
		$I->comment("Exiting Action Group [fillNewData] FillOutCMSPageContent");
		$I->comment("Entering Action Group [saveActivatedPage] SaveCmsPageActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForSplitButtonSaveActivatedPage
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonSaveActivatedPageWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButtonSaveActivatedPage
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonSaveActivatedPageWaitForPageLoad
		$I->waitForElementVisible("#save_and_close", 30); // stepKey: waitForSaveCmsPageSaveActivatedPage
		$I->waitForPageLoad(10); // stepKey: waitForSaveCmsPageSaveActivatedPageWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveCmsPageSaveActivatedPage
		$I->waitForPageLoad(10); // stepKey: clickSaveCmsPageSaveActivatedPageWaitForPageLoad
		$I->waitForElementVisible("#add", 1); // stepKey: waitForCmsPageSaveButtonSaveActivatedPage
		$I->waitForPageLoad(30); // stepKey: waitForCmsPageSaveButtonSaveActivatedPageWaitForPageLoad
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveActivatedPage
		$I->see("You saved the page.", ".message-success"); // stepKey: assertSavePageSuccessMessageSaveActivatedPage
		$I->comment("Exiting Action Group [saveActivatedPage] SaveCmsPageActionGroup");
		$I->comment("Verify data in admin");
		$I->comment("Entering Action Group [navigateToUpdatedCMSPage] NavigateToCreatedCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridNavigateToUpdatedCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToUpdatedCMSPage
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterNavigateToUpdatedCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToUpdatedCMSPage
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingNavigateToUpdatedCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishNavigateToUpdatedCMSPage
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingNavigateToUpdatedCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishNavigateToUpdatedCMSPage
		$I->click("//div[text()='testpage-" . msq("_duplicatedCMSPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectCreatedCMSPageNavigateToUpdatedCMSPage
		$I->click("//div[text()='testpage-" . msq("_duplicatedCMSPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']"); // stepKey: navigateToCreatedCMSPageNavigateToUpdatedCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToUpdatedCMSPage
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageNavigateToUpdatedCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToUpdatedCMSPage
		$I->comment("Exiting Action Group [navigateToUpdatedCMSPage] NavigateToCreatedCMSPageActionGroup");
		$I->comment("Entering Action Group [verifyPageDataInAdmin] AssertCMSPageContentActionGroup");
		$grabTextFromTitleVerifyPageDataInAdmin = $I->grabValueFrom("input[name=title]"); // stepKey: grabTextFromTitleVerifyPageDataInAdmin
		$I->assertEquals("testpage", $grabTextFromTitleVerifyPageDataInAdmin, "pass"); // stepKey: assertTitleVerifyPageDataInAdmin
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageVerifyPageDataInAdmin
		$grabTextFromContentVerifyPageDataInAdmin = $I->grabValueFrom("#cms_page_form_content"); // stepKey: grabTextFromContentVerifyPageDataInAdmin
		$I->assertEquals("Sample page content. Yada yada yada.", $grabTextFromContentVerifyPageDataInAdmin, "pass"); // stepKey: assertContentVerifyPageDataInAdmin
		$I->click("div[data-index=search_engine_optimisation]"); // stepKey: clickExpandSearchEngineOptimisationVerifyPageDataInAdmin
		$I->waitForPageLoad(30); // stepKey: clickExpandSearchEngineOptimisationVerifyPageDataInAdminWaitForPageLoad
		$setAttributeVerifyPageDataInAdmin = $I->executeJS("(el = document.querySelector('[name=\'identifier\']')) && el['se' + 'tAt' + 'tribute']('data-value', el.value.split('-')[0]);"); // stepKey: setAttributeVerifyPageDataInAdmin
		$I->seeElement("//input[contains(@data-value,'testpage')]"); // stepKey: seeVerifyPageDataInAdmin
		$I->comment("Exiting Action Group [verifyPageDataInAdmin] AssertCMSPageContentActionGroup");
		$I->comment("Verify data on frontend");
		$I->comment("Entering Action Group [navigateToPageOnStorefront] StorefrontGoToCMSPageActionGroup");
		$I->amOnPage("//testpage-" . msq("_duplicatedCMSPage")); // stepKey: amOnCmsPageOnStorefrontNavigateToPageOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOnStorefrontNavigateToPageOnStorefront
		$I->comment("Exiting Action Group [navigateToPageOnStorefront] StorefrontGoToCMSPageActionGroup");
		$I->comment("Entering Action Group [verifyPageDataOnFrontend] AssertStoreFrontCMSPageActionGroup");
		$I->see("testpage", "//div[@class='breadcrumbs']//ul/li[@class='item cms_page']"); // stepKey: seeTitleVerifyPageDataOnFrontend
		$I->see("Test Content Heading", "#maincontent .page-title"); // stepKey: seeContentHeadingVerifyPageDataOnFrontend
		$I->see("Sample page content. Yada yada yada.", "#maincontent"); // stepKey: seeContentVerifyPageDataOnFrontend
		$I->comment("Exiting Action Group [verifyPageDataOnFrontend] AssertStoreFrontCMSPageActionGroup");
	}
}
