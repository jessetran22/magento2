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
 * @Title("MAGETWO-93941: Captcha forms displaying")
 * @Description("Captcha forms displaying<h3>Test files</h3>app/code/Magento/Captcha/Test/Mftf/Test/CaptchaFormsDisplayingTest/CaptchaFormsDisplayingTest.xml<br>")
 * @TestCaseId("MAGETWO-93941")
 * @group captcha
 */
class CaptchaFormsDisplayingTestCest
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
	 * @Features({"Captcha"})
	 * @Stories({"MAGETWO-91552 - [github] CAPTCHA doesn't show when check out as guest"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function CaptchaFormsDisplayingTest(AcceptanceTester $I)
	{
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->comment("Go to Captcha");
		$I->comment("Entering Action Group [CaptchaFormsDisplayingActionGroup] CaptchaFormsDisplayingActionGroup");
		$I->click("#menu-magento-backend-stores"); // stepKey: ClickToGoStoresCaptchaFormsDisplayingActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForStoresLoadedCaptchaFormsDisplayingActionGroup
		$I->click("//li[@data-ui-id='menu-magento-config-system-config']//span"); // stepKey: ClickToGoConfigurationCaptchaFormsDisplayingActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForConfigurationsLoadedCaptchaFormsDisplayingActionGroup
		$I->scrollTo("//div[@class='admin__page-nav-title title _collapsible']//strong[text()='Customers']", 0, -80); // stepKey: ScrollToCustomersCaptchaFormsDisplayingActionGroup
		$I->click("//div[@class='admin__page-nav-title title _collapsible']//strong[text()='Customers']"); // stepKey: ClickToCustomersCaptchaFormsDisplayingActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForCustomerConfigurationsLoadedCaptchaFormsDisplayingActionGroup
		$I->click("//span[text()='Customer Configuration']"); // stepKey: ClickToGoCustomerConfigurationCaptchaFormsDisplayingActionGroup
		$I->scrollTo("#customer_captcha-head"); // stepKey: scrollToCaptchaCaptchaFormsDisplayingActionGroup
		$I->conditionalClick("#customer_captcha-head", "a#customer_captcha-head.open", false); // stepKey: ClickToOpenCaptchaCaptchaFormsDisplayingActionGroup
		$I->comment("Exiting Action Group [CaptchaFormsDisplayingActionGroup] CaptchaFormsDisplayingActionGroup");
		$I->waitForPageLoad(30); // stepKey: WaitForPageLoaded
		$I->comment("Verify fields removed");
		$formItems = $I->grabTextFrom("#customer_captcha_forms"); // stepKey: formItems
		$I->assertStringNotContainsString("Check Out as Guest", $formItems); // stepKey: checkoutAsGuest
		$I->assertStringNotContainsString("Register during Checkout", $formItems); // stepKey: register
		$I->comment("Verify fields existence");
		$createUser = $I->grabTextFrom("//select[@id='customer_captcha_forms']/option[@value='user_create']"); // stepKey: createUser
		$I->assertEquals("Create user", $createUser); // stepKey: CreateUserFieldIsPresent
		$login = $I->grabTextFrom("//select[@id='customer_captcha_forms']/option[@value='user_login']"); // stepKey: login
		$I->assertEquals("Login", $login); // stepKey: LoginFieldIsPresent
		$forgotpassword = $I->grabTextFrom("//select[@id='customer_captcha_forms']/option[@value='user_forgotpassword']"); // stepKey: forgotpassword
		$I->assertEquals("Forgot password", $forgotpassword); // stepKey: PasswordFieldIsPresent
		$contactUs = $I->grabTextFrom("//select[@id='customer_captcha_forms']/option[@value='contact_us']"); // stepKey: contactUs
		$I->assertEquals("Contact Us", $contactUs); // stepKey: contactUsFieldIsPresent
		$userEdit = $I->grabTextFrom("//select[@id='customer_captcha_forms']/option[@value='user_edit']"); // stepKey: userEdit
		$I->assertEquals("Change password", $userEdit); // stepKey: userEditFieldIsPresent
		$I->comment("Roll back configuration");
		$I->scrollToTopOfPage(); // stepKey: ScrollToTop
		$I->click("#customer_captcha-head"); // stepKey: ClickToCloseCaptcha
	}
}
