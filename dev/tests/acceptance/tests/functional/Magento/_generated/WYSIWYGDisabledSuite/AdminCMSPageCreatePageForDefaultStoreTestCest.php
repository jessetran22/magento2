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
 * @Title("MC-14676: Create CMS Page via the Admin for default store")
 * @Description("Admin should be able to create a CMS Page<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminCMSPageCreatePageForDefaultStoreTest.xml<br>")
 * @TestCaseId("MC-14676")
 * @group backend
 * @group Cms
 * @group mtf_migrated
 * @group WYSIWYGDisabled
 */
class AdminCMSPageCreatePageForDefaultStoreTestCest
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
	public function AdminCMSPageCreatePageForDefaultStoreTest(AcceptanceTester $I)
	{
		$I->comment("Go to New CMS Page page");
		$I->comment("Entering Action Group [navigateToCreateNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/new"); // stepKey: navigateToCreateNewPageNavigateToCreateNewPage
		$I->waitForPageLoad(30); // stepKey: waitForNewPagePageLoadNavigateToCreateNewPage
		$I->comment("Exiting Action Group [navigateToCreateNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->comment("Fill the CMS page form");
		$I->comment("Entering Action Group [fillBasicPageDataForPageWithDefaultStore] FillOutCMSPageContent");
		$I->fillField("input[name=title]", "testpage"); // stepKey: fillFieldTitleFillBasicPageDataForPageWithDefaultStore
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageFillBasicPageDataForPageWithDefaultStore
		$I->fillField("input[name=content_heading]", "Test Content Heading"); // stepKey: fillFieldContentHeadingFillBasicPageDataForPageWithDefaultStore
		$I->scrollTo("#cms_page_form_content"); // stepKey: scrollToPageContentFillBasicPageDataForPageWithDefaultStore
		$I->fillField("#cms_page_form_content", "Sample page content. Yada yada yada."); // stepKey: fillFieldContentFillBasicPageDataForPageWithDefaultStore
		$I->click("div[data-index=search_engine_optimisation]"); // stepKey: clickExpandSearchEngineOptimisationFillBasicPageDataForPageWithDefaultStore
		$I->waitForPageLoad(30); // stepKey: clickExpandSearchEngineOptimisationFillBasicPageDataForPageWithDefaultStoreWaitForPageLoad
		$I->fillField("input[name=identifier]", "testpage-" . msq("_duplicatedCMSPage")); // stepKey: fillFieldUrlKeyFillBasicPageDataForPageWithDefaultStore
		$I->comment("Exiting Action Group [fillBasicPageDataForPageWithDefaultStore] FillOutCMSPageContent");
		$I->comment("Entering Action Group [selectCMSPageStoreView] AdminSelectCMSPageStoreViewActionGroup");
		$I->click("div[data-index=websites]"); // stepKey: clickPageInWebsitesSelectCMSPageStoreView
		$I->waitForPageLoad(30); // stepKey: clickPageInWebsitesSelectCMSPageStoreViewWaitForPageLoad
		$I->waitForElementVisible("//option[contains(text(),'Default Store View')]", 30); // stepKey: waitForStoreGridReloadSelectCMSPageStoreView
		$I->clickWithLeftButton("//option[contains(text(),'Default Store View')]"); // stepKey: clickStoreViewSelectCMSPageStoreView
		$I->comment("Exiting Action Group [selectCMSPageStoreView] AdminSelectCMSPageStoreViewActionGroup");
		$I->comment("Verify successfully saved");
		$I->comment("Entering Action Group [savePageWithDefaultStore] SaveCmsPageActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForSplitButtonSavePageWithDefaultStore
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonSavePageWithDefaultStoreWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButtonSavePageWithDefaultStore
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonSavePageWithDefaultStoreWaitForPageLoad
		$I->waitForElementVisible("#save_and_close", 30); // stepKey: waitForSaveCmsPageSavePageWithDefaultStore
		$I->waitForPageLoad(10); // stepKey: waitForSaveCmsPageSavePageWithDefaultStoreWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveCmsPageSavePageWithDefaultStore
		$I->waitForPageLoad(10); // stepKey: clickSaveCmsPageSavePageWithDefaultStoreWaitForPageLoad
		$I->waitForElementVisible("#add", 1); // stepKey: waitForCmsPageSaveButtonSavePageWithDefaultStore
		$I->waitForPageLoad(30); // stepKey: waitForCmsPageSaveButtonSavePageWithDefaultStoreWaitForPageLoad
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSavePageWithDefaultStore
		$I->see("You saved the page.", ".message-success"); // stepKey: assertSavePageSuccessMessageSavePageWithDefaultStore
		$I->comment("Exiting Action Group [savePageWithDefaultStore] SaveCmsPageActionGroup");
		$I->comment("Navigate to page in Admin");
		$I->comment("Entering Action Group [navigateToCMSPageWithDefaultStoreInAdmin] NavigateToCreatedCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridNavigateToCMSPageWithDefaultStoreInAdmin
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCMSPageWithDefaultStoreInAdmin
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterNavigateToCMSPageWithDefaultStoreInAdmin
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCMSPageWithDefaultStoreInAdmin
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingNavigateToCMSPageWithDefaultStoreInAdmin
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishNavigateToCMSPageWithDefaultStoreInAdmin
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingNavigateToCMSPageWithDefaultStoreInAdmin
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishNavigateToCMSPageWithDefaultStoreInAdmin
		$I->click("//div[text()='testpage-" . msq("_duplicatedCMSPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectCreatedCMSPageNavigateToCMSPageWithDefaultStoreInAdmin
		$I->click("//div[text()='testpage-" . msq("_duplicatedCMSPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']"); // stepKey: navigateToCreatedCMSPageNavigateToCMSPageWithDefaultStoreInAdmin
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCMSPageWithDefaultStoreInAdmin
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageNavigateToCMSPageWithDefaultStoreInAdmin
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCMSPageWithDefaultStoreInAdmin
		$I->comment("Exiting Action Group [navigateToCMSPageWithDefaultStoreInAdmin] NavigateToCreatedCMSPageActionGroup");
		$I->comment("Verify Page Data in Admin");
		$I->comment("Entering Action Group [verifyPageWithDefaultStoreDataInAdmin] AssertCMSPageContentActionGroup");
		$grabTextFromTitleVerifyPageWithDefaultStoreDataInAdmin = $I->grabValueFrom("input[name=title]"); // stepKey: grabTextFromTitleVerifyPageWithDefaultStoreDataInAdmin
		$I->assertEquals("testpage", $grabTextFromTitleVerifyPageWithDefaultStoreDataInAdmin, "pass"); // stepKey: assertTitleVerifyPageWithDefaultStoreDataInAdmin
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageVerifyPageWithDefaultStoreDataInAdmin
		$grabTextFromContentVerifyPageWithDefaultStoreDataInAdmin = $I->grabValueFrom("#cms_page_form_content"); // stepKey: grabTextFromContentVerifyPageWithDefaultStoreDataInAdmin
		$I->assertEquals("Sample page content. Yada yada yada.", $grabTextFromContentVerifyPageWithDefaultStoreDataInAdmin, "pass"); // stepKey: assertContentVerifyPageWithDefaultStoreDataInAdmin
		$I->click("div[data-index=search_engine_optimisation]"); // stepKey: clickExpandSearchEngineOptimisationVerifyPageWithDefaultStoreDataInAdmin
		$I->waitForPageLoad(30); // stepKey: clickExpandSearchEngineOptimisationVerifyPageWithDefaultStoreDataInAdminWaitForPageLoad
		$setAttributeVerifyPageWithDefaultStoreDataInAdmin = $I->executeJS("(el = document.querySelector('[name=\'identifier\']')) && el['se' + 'tAt' + 'tribute']('data-value', el.value.split('-')[0]);"); // stepKey: setAttributeVerifyPageWithDefaultStoreDataInAdmin
		$I->seeElement("//input[contains(@data-value,'testpage')]"); // stepKey: seeVerifyPageWithDefaultStoreDataInAdmin
		$I->comment("Exiting Action Group [verifyPageWithDefaultStoreDataInAdmin] AssertCMSPageContentActionGroup");
		$I->comment("Verify Store ID");
		$I->comment("Entering Action Group [verifyStoreId] AssertCMSPageStoreIdActionGroup");
		$I->click("div[data-index=websites]"); // stepKey: clickPageInWebsitesVerifyStoreId
		$I->waitForPageLoad(30); // stepKey: clickPageInWebsitesVerifyStoreIdWaitForPageLoad
		$I->waitForElementVisible("//div[@data-bind=\"scope: 'cms_page_form.cms_page_form'\"]//select[@name='store_id']", 30); // stepKey: waitForStoresSectionReloadVerifyStoreId
		$grabValueFromStoreViewVerifyStoreId = $I->grabValueFrom("//div[@data-bind=\"scope: 'cms_page_form.cms_page_form'\"]//select[@name='store_id']"); // stepKey: grabValueFromStoreViewVerifyStoreId
		$I->assertEquals("1", $grabValueFromStoreViewVerifyStoreId, "pass"); // stepKey: assertTitleVerifyStoreId
		$I->comment("Exiting Action Group [verifyStoreId] AssertCMSPageStoreIdActionGroup");
		$I->comment("Delete page");
		$I->comment("Entering Action Group [deletePageWithDefaultStore] DeletePageByUrlKeyActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: amOnCMSNewPageDeletePageWithDefaultStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1DeletePageWithDefaultStore
		$I->click("//div[text()='testpage-" . msq("_duplicatedCMSPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectDeletePageWithDefaultStore
		$I->click("//div[text()='testpage-" . msq("_duplicatedCMSPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Delete']"); // stepKey: clickDeleteDeletePageWithDefaultStore
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForOkButtonToBeVisibleDeletePageWithDefaultStore
		$I->waitForPageLoad(60); // stepKey: waitForOkButtonToBeVisibleDeletePageWithDefaultStoreWaitForPageLoad
		$I->click(".action-primary.action-accept"); // stepKey: clickOkButtonDeletePageWithDefaultStore
		$I->waitForPageLoad(60); // stepKey: clickOkButtonDeletePageWithDefaultStoreWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3DeletePageWithDefaultStore
		$I->see("The page has been deleted."); // stepKey: seeSuccessMessageDeletePageWithDefaultStore
		$I->comment("Exiting Action Group [deletePageWithDefaultStore] DeletePageByUrlKeyActionGroup");
	}
}
