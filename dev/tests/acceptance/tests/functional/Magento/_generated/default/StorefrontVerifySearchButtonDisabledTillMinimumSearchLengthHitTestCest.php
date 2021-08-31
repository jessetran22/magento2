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
 * @Title("MC-37380: Verify search button is disabled if search term is less than minimum search length")
 * @Description("Storefront verify search button is disabled if search term is less than minimum search length<h3>Test files</h3>app/code/Magento/Search/Test/Mftf/Test/StorefrontVerifySearchButtonDisabledTillMinimumSearchLengthHitTest.xml<br>")
 * @TestCaseId("MC-37380")
 * @group searchFrontend
 */
class StorefrontVerifySearchButtonDisabledTillMinimumSearchLengthHitTestCest
{
	/**
	 * @Stories({"Search Term Disabled"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Features({"Search"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVerifySearchButtonDisabledTillMinimumSearchLengthHitTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOpenStoreFrontHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenStoreFrontHomePage
		$I->comment("Exiting Action Group [openStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [fillSearchByTextLessThanMinimumSearchLength] StoreFrontFillSearchActionGroup");
		$I->fillField("#search", "Te"); // stepKey: fillSearchFieldFillSearchByTextLessThanMinimumSearchLength
		$I->waitForElementVisible("button.action.search", 30); // stepKey: waitForSubmitButtonFillSearchByTextLessThanMinimumSearchLength
		$I->waitForPageLoad(30); // stepKey: waitForSubmitButtonFillSearchByTextLessThanMinimumSearchLengthWaitForPageLoad
		$I->comment("Exiting Action Group [fillSearchByTextLessThanMinimumSearchLength] StoreFrontFillSearchActionGroup");
		$I->comment("Entering Action Group [assertSearchButtonIsDisabled] AssertStorefrontVerifySearchButtonIsDisabledActionGroup");
		$grabSearchButtonDisabledAttributeAssertSearchButtonIsDisabled = $I->grabAttributeFrom("button.action.search", "disabled"); // stepKey: grabSearchButtonDisabledAttributeAssertSearchButtonIsDisabled
		$I->waitForPageLoad(30); // stepKey: grabSearchButtonDisabledAttributeAssertSearchButtonIsDisabledWaitForPageLoad
		$I->assertEquals("true", $grabSearchButtonDisabledAttributeAssertSearchButtonIsDisabled); // stepKey: assertSearchButtonDisabledAssertSearchButtonIsDisabled
		$I->comment("Exiting Action Group [assertSearchButtonIsDisabled] AssertStorefrontVerifySearchButtonIsDisabledActionGroup");
	}
}
