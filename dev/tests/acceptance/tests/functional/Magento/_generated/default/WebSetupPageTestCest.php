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
 * @Title("[NO TESTCASEID]: Setup Magento via Web Interface")
 * @Description("Setup Magento via Web Interface should show only landing section with logo, version, and welcome and licence section<h3>Test files</h3>app/code/Magento/Backend/Test/Mftf/Test/WebSetup/WebSetupPageTest.xml<br>")
 */
class WebSetupPageTestCest
{
	/**
	 * @Features({"Backend"})
	 * @Stories({"Setup Magento via Web Interface"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function WebSetupPageTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToWebSetupPage] GoToWebSetupPageActionGroup");
		$I->amOnPage("setup/"); // stepKey: goToWebSetupPageGoToWebSetupPage
		$I->waitForPageLoad(10); // stepKey: waitForWebSetupPageLoadGoToWebSetupPage
		$I->seeElementInDOM("section[data-section=landing]"); // stepKey: assertSetupPageHasLandingSectionGoToWebSetupPage
		$I->seeElementInDOM("section[data-section=license]"); // stepKey: assertSetupPageHasLicenseSectionGoToWebSetupPage
		$I->comment("Exiting Action Group [goToWebSetupPage] GoToWebSetupPageActionGroup");
		$I->seeElement("section[data-section=landing]"); // stepKey: assertLandingSectionVisibleInSetupPage
		$I->dontSeeElement("section[data-section=license]"); // stepKey: assertLicenseSectionInvisibleInSetupPage
		$I->seeElement("section[data-section=landing] > img.logo"); // stepKey: assertSetupPageLogoVisibleInSetupPage
		$I->seeElement("section[data-section=landing] > p.text-version"); // stepKey: assertVersionVisibleInSetupPage
		$I->seeElement("section[data-section=landing] > p.text-welcome"); // stepKey: assertWelcomeVisibleInSetupPage
		$I->comment("Entering Action Group [showLicense] WebSetupShowLicenseSectionActionGroup");
		$I->click("section[data-section=landing] > p.text-welcome > a[href^='javascript:showSection'][href*='license']"); // stepKey: showLicenseSectionShowLicense
		$I->waitForElementVisible("section[data-section=license]", 5); // stepKey: waitForVisibleWebSetupPageLicenseSectionShowLicense
		$I->comment("Exiting Action Group [showLicense] WebSetupShowLicenseSectionActionGroup");
		$I->seeElement("section[data-section=license]"); // stepKey: assertLicenseSectionVisibleInSetupPage
		$I->dontSeeElement("section[data-section=landing]"); // stepKey: assertLandingSectionInvisibleInSetupPage
		$I->comment("Entering Action Group [goBackToLanding] WebSetupShowLandingSectionActionGroup");
		$I->click("section[data-section=license] div.page-license-footer button[onclick^='showSection'][onclick*='landing']"); // stepKey: showLandingSectionGoBackToLanding
		$I->waitForElementVisible("section[data-section=landing]", 5); // stepKey: waitForVisibleWebSetupPageLandingSectionGoBackToLanding
		$I->comment("Exiting Action Group [goBackToLanding] WebSetupShowLandingSectionActionGroup");
		$I->seeElement("section[data-section=landing]"); // stepKey: assertLandingSectionVisibleAfterGoingBackFromLicenseSection
		$I->dontSeeElement("section[data-section=license]"); // stepKey: assertLicenseSectionInvisibleAfterGoingBackFromLicenseSection
	}
}
