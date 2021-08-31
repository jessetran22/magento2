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
 * @Title("MC-35728: Newsletter Subscription for guest is disabled and cannot be performed")
 * @Description("Guest cannot subscribe to Newsletter if it is disallowed in configurations<h3>Test files</h3>app/code/Magento/Newsletter/Test/Mftf/Test/StorefrontNewsletterGuestSubscriptionWithDisallowedOptionTest.xml<br>")
 * @group newsletter
 * @group configuration
 * @TestCaseId("MC-35728")
 */
class StorefrontNewsletterGuestSubscriptionWithDisallowedOptionTestCest
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
		$disableGuestSubscription = $I->magentoCLI("config:set newsletter/subscription/allow_guest_subscribe 0", 60); // stepKey: disableGuestSubscription
		$I->comment($disableGuestSubscription);
		$cleanCache = $I->magentoCLI("cache:clean config", 60); // stepKey: cleanCache
		$I->comment($cleanCache);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$allowGuestSubscription = $I->magentoCLI("config:set newsletter/subscription/allow_guest_subscribe 1", 60); // stepKey: allowGuestSubscription
		$I->comment($allowGuestSubscription);
		$cacheClean = $I->magentoCLI("cache:clean config", 60); // stepKey: cacheClean
		$I->comment($cacheClean);
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
	 * @Stories({"Disabled Guest Newsletter Subscription"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontNewsletterGuestSubscriptionWithDisallowedOptionTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOpenStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenStorefrontPage
		$I->comment("Exiting Action Group [openStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [createSubscription] StorefrontCreateNewsletterSubscriberActionGroup");
		$I->fillField(".control #newsletter", "admin@magento.com"); // stepKey: fillEmailFieldCreateSubscription
		$I->click(".actions .action.subscribe.primary"); // stepKey: submitFormCreateSubscription
		$I->waitForPageLoad(30); // stepKey: submitFormCreateSubscriptionWaitForPageLoad
		$I->comment("Exiting Action Group [createSubscription] StorefrontCreateNewsletterSubscriberActionGroup");
		$I->comment("Entering Action Group [assertMessage] StorefrontAssertErrorMessageActionGroup");
		$I->see("Sorry, but the administrator denied subscription for guests. Please register.", ".messages .message-error"); // stepKey: verifyMessageAssertMessage
		$I->comment("Exiting Action Group [assertMessage] StorefrontAssertErrorMessageActionGroup");
	}
}
