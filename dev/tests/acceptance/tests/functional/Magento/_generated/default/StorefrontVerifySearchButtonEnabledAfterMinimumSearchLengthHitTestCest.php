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
 * @Title("MC-37381: Verify search button is not disabled if search term is equal or greater than minimum search length")
 * @Description("Storefront verify search button is not disabled if search term is equal or greater than minimum search length<h3>Test files</h3>app/code/Magento/Search/Test/Mftf/Test/StorefrontVerifySearchButtonEnabledAfterMinimumSearchLengthHitTest.xml<br>")
 * @TestCaseId("MC-37381")
 * @group searchFrontend
 */
class StorefrontVerifySearchButtonEnabledAfterMinimumSearchLengthHitTestCest
{
	/**
	 * @Stories({"Search Button Not Disabled"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Features({"Search"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVerifySearchButtonEnabledAfterMinimumSearchLengthHitTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOpenStoreFrontHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenStoreFrontHomePage
		$I->comment("Exiting Action Group [openStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [fillSearchByTextMoreThanMinimumSearchLength] StoreFrontFillSearchActionGroup");
		$I->fillField("#search", "Magento"); // stepKey: fillSearchFieldFillSearchByTextMoreThanMinimumSearchLength
		$I->waitForElementVisible("button.action.search", 30); // stepKey: waitForSubmitButtonFillSearchByTextMoreThanMinimumSearchLength
		$I->waitForPageLoad(30); // stepKey: waitForSubmitButtonFillSearchByTextMoreThanMinimumSearchLengthWaitForPageLoad
		$I->comment("Exiting Action Group [fillSearchByTextMoreThanMinimumSearchLength] StoreFrontFillSearchActionGroup");
		$I->comment("Entering Action Group [assertSearchButtonIsNotDisabled] AssertStorefrontVerifySearchButtonIsEnabledActionGroup");
		$grabSearchButtonAttributeAssertSearchButtonIsNotDisabled = $I->grabAttributeFrom("button.action.search", "disabled"); // stepKey: grabSearchButtonAttributeAssertSearchButtonIsNotDisabled
		$I->waitForPageLoad(30); // stepKey: grabSearchButtonAttributeAssertSearchButtonIsNotDisabledWaitForPageLoad
		$I->assertEmpty("$grabSearchButtonAttributeAssertSearchButtonIsNotDisabled"); // stepKey: assertSearchButtonEnabledAssertSearchButtonIsNotDisabled
		$I->comment("Exiting Action Group [assertSearchButtonIsNotDisabled] AssertStorefrontVerifySearchButtonIsEnabledActionGroup");
	}
}
