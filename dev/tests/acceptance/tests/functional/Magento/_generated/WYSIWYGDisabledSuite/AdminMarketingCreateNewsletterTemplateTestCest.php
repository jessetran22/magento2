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
 * @Title("MC-29809: Newsletter Template Creation")
 * @Description("Newsletter Template Successfully Created<h3>Test files</h3>app/code/Magento/Newsletter/Test/Mftf/Test/AdminMarketingCreateNewsletterTemplateTest.xml<br>")
 * @group newsletter
 * @group mtf_migrated
 * @group WYSIWYGDisabled
 * @TestCaseId("MC-29809")
 */
class AdminMarketingCreateNewsletterTemplateTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete Created Newsletter Template");
		$I->comment("Entering Action Group [findCreatedNewsletterTemplateInGrid] AdminSearchNewsletterTemplateOnGridActionGroup");
		$I->fillField("[id$='filter_code']", "Test Newsletter Template" . msq("_defaultNewsletter")); // stepKey: filterNameFindCreatedNewsletterTemplateInGrid
		$I->fillField("[id$='filter_subject']", "Test Newsletter Subject"); // stepKey: filterSubjectFindCreatedNewsletterTemplateInGrid
		$I->click(".action-default.scalable.action-secondary"); // stepKey: clickSearchButtonFindCreatedNewsletterTemplateInGrid
		$I->waitForPageLoad(30); // stepKey: waitForNewNewsletterTemplatesPageLoadedAfterFilteringFindCreatedNewsletterTemplateInGrid
		$I->comment("Exiting Action Group [findCreatedNewsletterTemplateInGrid] AdminSearchNewsletterTemplateOnGridActionGroup");
		$I->comment("Entering Action Group [openTemplate] AdminMarketingOpenNewsletterTemplateFromGridActionGroup");
		$I->click(".data-grid>tbody>tr"); // stepKey: openTemplateOpenTemplate
		$I->comment("Exiting Action Group [openTemplate] AdminMarketingOpenNewsletterTemplateFromGridActionGroup");
		$I->comment("Entering Action Group [deleteTemplate] AdminMarketingDeleteNewsletterTemplateActionGroup");
		$I->click(".page-actions-inner .page-actions-buttons .delete"); // stepKey: clickDeleteButtonDeleteTemplate
		$I->click(".action-primary.action-accept"); // stepKey: confirmDeleteDeleteTemplate
		$I->waitForPageLoad(10); // stepKey: confirmDeleteDeleteTemplateWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadingDeleteTemplate
		$I->comment("Exiting Action Group [deleteTemplate] AdminMarketingDeleteNewsletterTemplateActionGroup");
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
	 * @Features({"Newsletter"})
	 * @Stories({"Admin Creates Newsletter Template"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMarketingCreateNewsletterTemplateTest(AcceptanceTester $I)
	{
		$I->comment("TEST BODY");
		$I->comment("Navigate To MARKETING > Newsletter Template");
		$I->comment("Entering Action Group [navigateToNewsletterTemplatePage] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToNewsletterTemplatePage
		$I->click("li[data-ui-id='menu-magento-backend-marketing']"); // stepKey: clickOnMenuItemNavigateToNewsletterTemplatePage
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToNewsletterTemplatePageWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-newsletter-newsletter-template']"); // stepKey: clickOnSubmenuItemNavigateToNewsletterTemplatePage
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToNewsletterTemplatePageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToNewsletterTemplatePage] AdminNavigateMenuActionGroup");
		$I->comment("Navigate To Create Newsletter Template Page");
		$I->comment("Entering Action Group [navigateToCreateNewsletterPage] AdminNavigateToCreateNewsletterTemplatePageActionGroup");
		$I->click(".page-actions .page-actions-buttons .add"); // stepKey: clickAddNewTemplateButtonNavigateToCreateNewsletterPage
		$I->waitForPageLoad(30); // stepKey: waitForNewNewsletterTemplatesPageLoadedNavigateToCreateNewsletterPage
		$I->comment("Exiting Action Group [navigateToCreateNewsletterPage] AdminNavigateToCreateNewsletterTemplatePageActionGroup");
		$I->comment("Create Newsletter Template");
		$I->comment("Entering Action Group [updateNewsletterTemplate] AdminMarketingCreateNewsletterTemplateActionGroup");
		$I->comment("Filling All Required Fields");
		$I->fillField("#code", "Test Newsletter Template" . msq("_defaultNewsletter")); // stepKey: fillTemplateNameFieldUpdateNewsletterTemplate
		$I->fillField("#subject", "Test Newsletter Subject"); // stepKey: fillTemplateSubjectFieldUpdateNewsletterTemplate
		$I->fillField("#sender_name", "Admin"); // stepKey: fillSenderNameFieldUpdateNewsletterTemplate
		$I->fillField("#sender_email", "admin@magento.com"); // stepKey: fillSenderEmailFieldUpdateNewsletterTemplate
		$I->fillField("textarea", "Some Test Content"); // stepKey: fillTemplateContentFieldUpdateNewsletterTemplate
		$I->comment("Saving Created Template");
		$I->click(".page-actions-inner .page-actions-buttons .save"); // stepKey: clickSaveTemplateButtonUpdateNewsletterTemplate
		$I->comment("Exiting Action Group [updateNewsletterTemplate] AdminMarketingCreateNewsletterTemplateActionGroup");
		$I->comment("Assert Success Message");
		$I->comment("Entering Action Group [seeSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleSeeSuccessMessage
		$I->see("The newsletter template has been saved.", "#messages div.message-success"); // stepKey: verifyMessageSeeSuccessMessage
		$I->comment("Exiting Action Group [seeSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Find Created Newsletter On grid");
		$I->comment("Entering Action Group [findCreatedNewsletterTemplate] AdminSearchNewsletterTemplateOnGridActionGroup");
		$I->fillField("[id$='filter_code']", "Test Newsletter Template" . msq("_defaultNewsletter")); // stepKey: filterNameFindCreatedNewsletterTemplate
		$I->fillField("[id$='filter_subject']", "Test Newsletter Subject"); // stepKey: filterSubjectFindCreatedNewsletterTemplate
		$I->click(".action-default.scalable.action-secondary"); // stepKey: clickSearchButtonFindCreatedNewsletterTemplate
		$I->waitForPageLoad(30); // stepKey: waitForNewNewsletterTemplatesPageLoadedAfterFilteringFindCreatedNewsletterTemplate
		$I->comment("Exiting Action Group [findCreatedNewsletterTemplate] AdminSearchNewsletterTemplateOnGridActionGroup");
		$I->comment("Assert Created Newsletter on Grid");
		$I->comment("Entering Action Group [assertNewsletterInGrid] AssertAdminCreatedNewsletterTemplateInGridActionGroup");
		$I->see("Test Newsletter Template" . msq("_defaultNewsletter"), "table.data-grid"); // stepKey: assertTemplatenameAssertNewsletterInGrid
		$I->see("Test Newsletter Subject", "table.data-grid"); // stepKey: assertTemplateSubjectAssertNewsletterInGrid
		$I->comment("Exiting Action Group [assertNewsletterInGrid] AssertAdminCreatedNewsletterTemplateInGridActionGroup");
		$I->comment("END TEST BODY");
	}
}
