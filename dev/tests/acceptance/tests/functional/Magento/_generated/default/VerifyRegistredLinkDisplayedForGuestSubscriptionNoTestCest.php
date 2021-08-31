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
 * @group Newsletter
 * @Title("[NO TESTCASEID]: Configure guest newsletter subscription to 'No'")
 * @Description("Configure guest newsletter subscription to 'No'<h3 class='y-label y-label_status_broken'>Deprecated Notice(s):</h3><ul><li>Use StorefrontNewsletterGuestSubscriptionWithDisallowedOptionTest</li></ul><h3>Test files</h3>app/code/Magento/Newsletter/Test/Mftf/Test/VerifyRegistredLinkDisplayedForGuestSubscriptionNoTest.xml<br>")
 */
class VerifyRegistredLinkDisplayedForGuestSubscriptionNoTestCest
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
		$setConfigGuestSubscriptionDisable = $I->magentoCLI("config:set newsletter/subscription/allow_guest_subscribe 0", 60); // stepKey: setConfigGuestSubscriptionDisable
		$I->comment($setConfigGuestSubscriptionDisable);
	}

	/**
	 * @Features({"Newsletter"})
	 * @Stories({"Configure guest newsletter subscription to 'No'"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function VerifyRegistredLinkDisplayedForGuestSubscriptionNoTest(AcceptanceTester $I)
	{
		$I->comment("Deprecated Due to inconsistency with the best practices");
		$I->amOnPage("/"); // stepKey: amOnStorefrontPage
		$I->submitForm("#newsletter-validate-detail", ['email' => 'admin@magento.com'], "{{BasicFrontendNewsletterFormSection.subscribeButton}}"); // stepKey: submitForm
		$I->waitForPageLoad(30); // stepKey: submitFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->waitForElementVisible("div.message-error.error.message", 30); // stepKey: waitForErrorAppears
	}
}
