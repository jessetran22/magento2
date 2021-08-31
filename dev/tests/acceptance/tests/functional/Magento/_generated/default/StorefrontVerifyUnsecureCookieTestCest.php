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
 * @Title("MC-36899: Verify Storefront Cookie Secure Config over http")
 * @Description("Verify that cookie are not secure on storefront over http<h3>Test files</h3>app/code/Magento/Cookie/Test/Mftf/Test/StorefrontVerifyUnsecureCookieTest.xml<br>")
 * @TestCaseId("MC-36899")
 * @group cookie
 * @group configuration
 */
class StorefrontVerifyUnsecureCookieTestCest
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
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
	 * @Features({"Cookie"})
	 * @Stories({"Storefront Secure Cookie"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVerifyUnsecureCookieTest(AcceptanceTester $I)
	{
		$I->amOnPage("/"); // stepKey: goToHomePage
		$isCookieSecure = $I->executeJS("return window.cookiesConfig.secure ? 'true' : 'false'"); // stepKey: isCookieSecure
		$I->assertEquals("false", $isCookieSecure); // stepKey: assertCookieIsUnsecure
		$isCookieSecure2 = $I->executeJS("return jQuery.mage.cookies.defaults.secure ? 'true' : 'false'"); // stepKey: isCookieSecure2
		$I->assertEquals("false", $isCookieSecure2); // stepKey: assertCookieIsSecure2
	}
}
