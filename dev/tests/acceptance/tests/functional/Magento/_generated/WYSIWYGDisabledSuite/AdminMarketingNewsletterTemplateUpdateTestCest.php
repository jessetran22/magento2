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
 * @Title("MC-39506: Newsletter Updating Test")
 * @Description("Admin should be able update created Newsletter Template<h3>Test files</h3>app/code/Magento/Newsletter/Test/Mftf/Test/AdminMarketingNewsletterTemplateUpdateTest.xml<br>")
 * @TestCaseId("MC-39506")
 * @group newsletter
 * @group reports
 * @group mtf_migrated
 * @group WYSIWYGDisabled
 */
class AdminMarketingNewsletterTemplateUpdateTestCest
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
		$I->comment("Entering Action Group [navigateToNewsletterTemplatePage] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToNewsletterTemplatePage
		$I->click("li[data-ui-id='menu-magento-backend-marketing']"); // stepKey: clickOnMenuItemNavigateToNewsletterTemplatePage
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToNewsletterTemplatePageWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-newsletter-newsletter-template']"); // stepKey: clickOnSubmenuItemNavigateToNewsletterTemplatePage
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToNewsletterTemplatePageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToNewsletterTemplatePage] AdminNavigateMenuActionGroup");
		$I->comment("Entering Action Group [navigateTiCreateNewsletterTemplatePage] AdminNavigateToCreateNewsletterTemplatePageActionGroup");
		$I->click(".page-actions .page-actions-buttons .add"); // stepKey: clickAddNewTemplateButtonNavigateTiCreateNewsletterTemplatePage
		$I->waitForPageLoad(30); // stepKey: waitForNewNewsletterTemplatesPageLoadedNavigateTiCreateNewsletterTemplatePage
		$I->comment("Exiting Action Group [navigateTiCreateNewsletterTemplatePage] AdminNavigateToCreateNewsletterTemplatePageActionGroup");
		$I->comment("Entering Action Group [createNewsletterTemplate] AdminMarketingCreateNewsletterTemplateActionGroup");
		$I->comment("Filling All Required Fields");
		$I->fillField("#code", "Test Newsletter Template" . msq("_defaultNewsletter")); // stepKey: fillTemplateNameFieldCreateNewsletterTemplate
		$I->fillField("#subject", "Test Newsletter Subject"); // stepKey: fillTemplateSubjectFieldCreateNewsletterTemplate
		$I->fillField("#sender_name", "Admin"); // stepKey: fillSenderNameFieldCreateNewsletterTemplate
		$I->fillField("#sender_email", "admin@magento.com"); // stepKey: fillSenderEmailFieldCreateNewsletterTemplate
		$I->fillField("textarea", "Some Test Content"); // stepKey: fillTemplateContentFieldCreateNewsletterTemplate
		$I->comment("Saving Created Template");
		$I->click(".page-actions-inner .page-actions-buttons .save"); // stepKey: clickSaveTemplateButtonCreateNewsletterTemplate
		$I->comment("Exiting Action Group [createNewsletterTemplate] AdminMarketingCreateNewsletterTemplateActionGroup");
		$I->comment("Entering Action Group [findCreatedNewsletterTemplate] AdminSearchNewsletterTemplateOnGridActionGroup");
		$I->fillField("[id$='filter_code']", "Test Newsletter Template" . msq("_defaultNewsletter")); // stepKey: filterNameFindCreatedNewsletterTemplate
		$I->fillField("[id$='filter_subject']", "Test Newsletter Subject"); // stepKey: filterSubjectFindCreatedNewsletterTemplate
		$I->click(".action-default.scalable.action-secondary"); // stepKey: clickSearchButtonFindCreatedNewsletterTemplate
		$I->waitForPageLoad(30); // stepKey: waitForNewNewsletterTemplatesPageLoadedAfterFilteringFindCreatedNewsletterTemplate
		$I->comment("Exiting Action Group [findCreatedNewsletterTemplate] AdminSearchNewsletterTemplateOnGridActionGroup");
		$I->comment("Entering Action Group [openCreatedNewsletterTemplate] AdminMarketingOpenNewsletterTemplateFromGridActionGroup");
		$I->click(".data-grid>tbody>tr"); // stepKey: openTemplateOpenCreatedNewsletterTemplate
		$I->comment("Exiting Action Group [openCreatedNewsletterTemplate] AdminMarketingOpenNewsletterTemplateFromGridActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToNewsletterGridPage] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToNewsletterGridPage
		$I->click("li[data-ui-id='menu-magento-backend-marketing']"); // stepKey: clickOnMenuItemNavigateToNewsletterGridPage
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToNewsletterGridPageWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-newsletter-newsletter-template']"); // stepKey: clickOnSubmenuItemNavigateToNewsletterGridPage
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToNewsletterGridPageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToNewsletterGridPage] AdminNavigateMenuActionGroup");
		$I->comment("Entering Action Group [findCreatedNewsletterTemplateInGrid] AdminSearchNewsletterTemplateOnGridActionGroup");
		$I->fillField("[id$='filter_code']", "Updated Newsletter Template" . msq("updatedNewsletter")); // stepKey: filterNameFindCreatedNewsletterTemplateInGrid
		$I->fillField("[id$='filter_subject']", "Updated Newsletter Subject"); // stepKey: filterSubjectFindCreatedNewsletterTemplateInGrid
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
	 * @Features({"Newsletter"})
	 * @Stories({"Newsletter Updating"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMarketingNewsletterTemplateUpdateTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [updateNewsletterTemplate] AdminMarketingCreateNewsletterTemplateActionGroup");
		$I->comment("Filling All Required Fields");
		$I->fillField("#code", "Updated Newsletter Template" . msq("updatedNewsletter")); // stepKey: fillTemplateNameFieldUpdateNewsletterTemplate
		$I->fillField("#subject", "Updated Newsletter Subject"); // stepKey: fillTemplateSubjectFieldUpdateNewsletterTemplate
		$I->fillField("#sender_name", "Admin"); // stepKey: fillSenderNameFieldUpdateNewsletterTemplate
		$I->fillField("#sender_email", "admin@magento.com"); // stepKey: fillSenderEmailFieldUpdateNewsletterTemplate
		$I->fillField("textarea", "Some Updated Test Content"); // stepKey: fillTemplateContentFieldUpdateNewsletterTemplate
		$I->comment("Saving Created Template");
		$I->click(".page-actions-inner .page-actions-buttons .save"); // stepKey: clickSaveTemplateButtonUpdateNewsletterTemplate
		$I->comment("Exiting Action Group [updateNewsletterTemplate] AdminMarketingCreateNewsletterTemplateActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleAssertSuccessMessage
		$I->see("The newsletter template has been saved.", "#messages div.message-success"); // stepKey: verifyMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [findCreatedNewsletterTemplate] AdminSearchNewsletterTemplateOnGridActionGroup");
		$I->fillField("[id$='filter_code']", "Updated Newsletter Template" . msq("updatedNewsletter")); // stepKey: filterNameFindCreatedNewsletterTemplate
		$I->fillField("[id$='filter_subject']", "Updated Newsletter Subject"); // stepKey: filterSubjectFindCreatedNewsletterTemplate
		$I->click(".action-default.scalable.action-secondary"); // stepKey: clickSearchButtonFindCreatedNewsletterTemplate
		$I->waitForPageLoad(30); // stepKey: waitForNewNewsletterTemplatesPageLoadedAfterFilteringFindCreatedNewsletterTemplate
		$I->comment("Exiting Action Group [findCreatedNewsletterTemplate] AdminSearchNewsletterTemplateOnGridActionGroup");
		$I->comment("Entering Action Group [assertNewsletterInGrid] AssertAdminCreatedNewsletterTemplateInGridActionGroup");
		$I->see("Updated Newsletter Template" . msq("updatedNewsletter"), "table.data-grid"); // stepKey: assertTemplatenameAssertNewsletterInGrid
		$I->see("Updated Newsletter Subject", "table.data-grid"); // stepKey: assertTemplateSubjectAssertNewsletterInGrid
		$I->comment("Exiting Action Group [assertNewsletterInGrid] AssertAdminCreatedNewsletterTemplateInGridActionGroup");
		$I->comment("Entering Action Group [findUpdatedNewsletterTemplate] AdminSearchNewsletterTemplateOnGridActionGroup");
		$I->fillField("[id$='filter_code']", "Updated Newsletter Template" . msq("updatedNewsletter")); // stepKey: filterNameFindUpdatedNewsletterTemplate
		$I->fillField("[id$='filter_subject']", "Updated Newsletter Subject"); // stepKey: filterSubjectFindUpdatedNewsletterTemplate
		$I->click(".action-default.scalable.action-secondary"); // stepKey: clickSearchButtonFindUpdatedNewsletterTemplate
		$I->waitForPageLoad(30); // stepKey: waitForNewNewsletterTemplatesPageLoadedAfterFilteringFindUpdatedNewsletterTemplate
		$I->comment("Exiting Action Group [findUpdatedNewsletterTemplate] AdminSearchNewsletterTemplateOnGridActionGroup");
		$I->comment("Entering Action Group [openTemplate] AdminMarketingOpenNewsletterTemplateFromGridActionGroup");
		$I->click(".data-grid>tbody>tr"); // stepKey: openTemplateOpenTemplate
		$I->comment("Exiting Action Group [openTemplate] AdminMarketingOpenNewsletterTemplateFromGridActionGroup");
		$I->comment("Entering Action Group [assertNewsletterForm] AssertAdminNewsletterTemplateFormActionGroup");
		$I->seeInField("#code", "Updated Newsletter Template" . msq("updatedNewsletter")); // stepKey: seeTemplateNameFieldAssertNewsletterForm
		$I->seeInField("#subject", "Updated Newsletter Subject"); // stepKey: seeTemplateSubjectFieldAssertNewsletterForm
		$I->seeInField("#sender_name", "Admin"); // stepKey: seeTemplateSenderNameFieldAssertNewsletterForm
		$I->seeInField("#sender_email", "admin@magento.com"); // stepKey: seeTemplateSenderEmailFieldAssertNewsletterForm
		$I->seeInField("textarea", "Some Updated Test Content"); // stepKey: seeTemplateContentFieldAssertNewsletterForm
		$I->comment("Exiting Action Group [assertNewsletterForm] AssertAdminNewsletterTemplateFormActionGroup");
	}
}
