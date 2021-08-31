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
 * @Title("[NO TESTCASEID]: Empty name for Guest Customer")
 * @Description("'Customer First Name' and 'Customer Last Name' should be empty for Guest Customer in Newsletter Subscribers Grid<h3>Test files</h3>app/code/Magento/Newsletter/Test/Mftf/Test/AdminNameEmptyForGuestTest.xml<br>")
 */
class AdminNameEmptyForGuestTestCest
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
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Stories({"Newsletter Subscribers grid"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminNameEmptyForGuestTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [amOnStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageAmOnStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadAmOnStorefrontPage
		$I->comment("Exiting Action Group [amOnStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->scrollTo("//footer"); // stepKey: scrollToFooter
		$I->fillField("input#newsletter", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: giveEmail
		$I->click("//form[@id='newsletter-validate-detail']//button[contains(@class, 'subscribe')]"); // stepKey: clickSubscribeButton
		$I->waitForPageLoad(15); // stepKey: clickSubscribeButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->see("Thank you for your subscription.", ".message-success"); // stepKey: checkSuccessMessage
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/newsletter/subscriber/index/"); // stepKey: amOnNewsletterSubscribersPage
		$I->see(msq("Simple_US_Customer") . "John.Doe@example.com", "//table[contains(@class, 'data-grid')]/tbody/tr[1][@data-role='row']/td[@data-column='email']"); // stepKey: checkEmail
		$I->see("Guest", "//table[contains(@class, 'data-grid')]/tbody/tr[1][@data-role='row']/td[@data-column='type']"); // stepKey: checkType
		$I->see("", "//table[contains(@class, 'data-grid')]/tbody/tr[1][@data-role='row']/td[@data-column='firstname']"); // stepKey: checkFirstName
		$I->see("", "//table[contains(@class, 'data-grid')]/tbody/tr[1][@data-role='row']/td[@data-column='lastname']"); // stepKey: checkLastName
	}
}
